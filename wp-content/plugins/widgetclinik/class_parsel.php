<?php
// Парсел xml файлов
class widget_clinik_class {
    
    // Параметры
    public $config;
    
    // Услуги
    public $xmlClassifier;
    public $arrayClassifier = array();
    public $depthGroupClassifier = 0;
    
    // Врачи
    public $arrayClassifierDoctor = array();
    
    // Каталог
    public $arrayCatalogs = array();
    
    function widget_clinik_class($fileName){
        
        $fileName = plugin_dir_path( __FILE__ ).$fileName;
        $this->config = new widgetclinikConfig();
        // Загрузка xml файла
	if (file_exists($fileName)) 
	{
		$this->xmlClassifier = simplexml_load_file($fileName);
	} 
	else 
	{
		exit('Не удалось открыть файл '.$fileName);
	}
        
    }
    
    
    // Заполнение таблицы услуги
    function updateTableClassifier($name, $parent, $id_1c){
        global $wpdb;
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        // Проверяем возможно есть такая запись в базе
        $rows = $wpdb->get_results($wpdb->escape( "SELECT * FROM `".$this->config->sql_table_clinik["categories"]["name"] )."` WHERE `id_1с` = '".$wpdb->escape($id_1c)."'");
        
        if(count($rows)==0){
            // Пишем если нет запис
            $wpdb->insert( $this->config->sql_table_clinik["categories"]["name"], array( 'parent' => $parent, 'id_1с' => $wpdb->escape($id_1c), 'name' => $wpdb->escape($name) ) );
            $inset_id_categories = $wpdb->insert_id;
            $wpdb->insert( $this->config->sql_table_clinik["service"]["name"], array( 'id_categories' => $inset_id_categories, 'id_1с' => $wpdb->escape($id_1c), 'name' => $wpdb->escape($name) ) );
            return $inset_id_categories;
        }else{
            // Вернем id записи если такая запись уже есть
            return $rows[0]->id;
        }
    }
    
    
    // Циклическая функция
    function reClassifier($gr){
            if(!empty($gr->Группы->Группа)){
               print "<ul>";
                $this->depthGroupClassifier++;
                    foreach ($gr->Группы->Группа as $item)
                    {
                        
                        // Логические действия
                        $id_db = 0;
                        if($this->arrayClassifier[count($this->arrayClassifier)-1]["depth"] < $this->depthGroupClassifier){
                            $id_db = $this->arrayClassifier[count($this->arrayClassifier)-1]["id_db"];
                        } else {
                            
                            for ($i = count($this->arrayClassifier); $i > 0; $i--) {
                              //  print $this->arrayClassifier[$i-1]["depth"]."=".$this->depthGroupClassifier;
                                if($this->arrayClassifier[$i-1]["depth"] == $this->depthGroupClassifier);
                                {
                                  //  print "bingo=".$this->arrayClassifier[$i-1]["id_db_joid"];
                                    $id_db = $this->arrayClassifier[$i-1]["id_db_joid"];
                                    break;
                                }
                            } 
                        }
                        
                        
                        // Запись в базу и массив
                        $this->arrayClassifier[] = array( 
                            "id_1c"=>$item->Ид, 
                            "name"=>$item->Наименование, 
                            "depth"=>$this->depthGroupClassifier, 
                            "id_db_joid"=>$id_db,
                            "id_db" => $this->updateTableClassifier($item->Наименование, $id_db, $item->Ид) );
                        
                        // Вывод на списка
                        //print "<li>".$item->Наименование." глубина - ".$this->depthGroupClassifier;
                            $this->reClassifier($item);
                        //print "</li>";
                    }
                $this->depthGroupClassifier--;
               print "</ul>";
            }
    }
    
    // Получаем услуги
    function getClassifier(){
        print "<ul>";
            foreach ($this->xmlClassifier->Классификатор->Группы->Группа as $item)
            {
                $this->depthGroupClassifier = 0;
                
                $this->arrayClassifier[] = array( 
                    "id_1c"=>$item->Ид, 
                    "name"=>$item->Наименование, 
                    "depth"=>$this->depthGroupClassifier, 
                    "id_db_joid"=>0, 
                    "id_db" => $this->updateTableClassifier($item->Наименование, 0, $item->Ид) );
                
                //print "<li>".$item->Наименование." глубина - ".$this->depthGroupClassifier;
                    $this->reClassifier($item);
                //print "</li>";
            }
        print "</ul>";
    }
    
    
    // Заполнение таблицы врачей
    function updateTableClassifierDoctor($name, $id_1c){
        global $wpdb;
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        
         // Проверяем возможно есть такая запись в базе
        $rows = $wpdb->get_results($wpdb->escape( "SELECT * FROM `".$this->config->sql_table_clinik["doctor"]["name"] )."` WHERE `id_1с` = '".$wpdb->escape($id_1c)."'");
        
        if(count($rows)==0){
            // Пишем если нет запис
            $rows_affected = $wpdb->insert( $this->config->sql_table_clinik["doctor"]["name"], array( 'id_1с' => $wpdb->escape($id_1c), 'name' => $wpdb->escape($name) ) );
            return $wpdb->insert_id;
        }else{
            // Вернем id записи если такая запись уже есть
            return $rows[0]->id;
        }
        
        
    }
    
    
    // Привязка врачей к услугам и запись врачей в базу
    function getClassifierDoctor(){
        
        
        // Считываем какой доктор к какой услуге относится
        foreach ($this->xmlClassifier->КлассификаторВрачей->Врач as $item)
        {
            
            $this->arrayClassifierDoctor[] = array( 
                "Имя" => $item->Имя,
                "id_1c" => $item->Ид);
            
            $this->updateTableClassifierDoctor($item->Имя, $item->Ид);
            
        } 
        
    }
    
    
    // Заполнение таблицы doctor_to_service
    function updateTableDoctorToService($id_service, $id_doctor){
        global $wpdb;
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        
         // Проверяем возможно есть такая запись в базе
        $rows = $wpdb->get_results($wpdb->escape( "SELECT * FROM `".$this->config->sql_table_clinik["doctor_to_service"]["name"] )."`"
                . " WHERE `id_service` = '".$wpdb->escape($id_service)."' AND `id_doctor` = '".$wpdb->escape($id_doctor)."'");
        
        if(count($rows)==0){
            // Пишем если нет запис
            $rows_affected = $wpdb->insert( $this->config->sql_table_clinik["doctor_to_service"]["name"], array( 'id_service' => $wpdb->escape($id_service), 'id_doctor' => $wpdb->escape($id_doctor) ) );
            return $wpdb->insert_id;
        }else{
            // Вернем id записи если такая запись уже есть
            return $rows[0]->id;
        }
        
        
    }
    
    
    
    
    
    // Привязка врачей каталогу
    function getDoctorToCatalogs(){
        global $wpdb;
        
        // id Услуги в базе
        $id_service = -1;
        
        // id Врача в базе
        $id_doctor = -1;
       
        // Считываем услуги
        foreach ($this->xmlClassifier->Каталог->Товары->Товар as $item)
        {

        $rows = $wpdb->get_results($wpdb->escape( "SELECT * FROM `".$this->config->sql_table_clinik["service"]["name"] )."` WHERE `id_1с` = '".$item->Группы->Ид."'");
        $id_service = $rows[0]->id;
        
            // Считываем врачей которые выполняю эти услуги
            if( !empty($item->Врачи->Врач) )
            foreach ($item->Врачи->Врач as $doctor)
            {
                
                $rows = $wpdb->get_results($wpdb->escape( "SELECT * FROM `".$this->config->sql_table_clinik["doctor"]["name"] )."` WHERE `id_1с` = '".$doctor->Ид."'");
                $id_doctor = $rows[0]->id;
                 //print "id_doctor = " . $id_doctor."<br/>";
                
                 $this->updateTableDoctorToService($id_service, $id_doctor);
                
            }
           
            
        }
    }
    
    
}

?>
