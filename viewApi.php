<head>
<style>table, th, td { border:1px solid black; }</style>
</head>
<?php        
        require("class.pdofactory.php");                
        require("abstract.databoundobject.php");        
        require("class.sols_checked.php");               
        require("class.sols_hours_with_data.php");               
        require("class.sols_keys.php");               
        require("class.validity_checks_parameters.php");               
        require("class.validity_checks.php");               
       
        print "Running...<br />";  
        $strDSN = "pgsql:dbname=nasadbcano;host=localhost;port=5432";
        /*Obte la conexió*/
        $objPDO = PDOFactory::GetPDO($strDSN, "postgres", "root", array());
        /*Asigna els parametres*/
        $objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);              
        /*
        CREAR TABLAS
        ************

        create table sols_hours_with_data(ID serial, code int, type varchar(10), value int, primary key(ID, code, type));
        create table validity_checks(ID serial, code int, type varchar(10), isvalid boolean, primary key(ID, code, type));
        create table validity_checks_parameters(ID serial, key varchar(255), value int, primary key(id, key));
        create table sols_checked(ID serial, code int, primary key(ID, code));
        create table sol_keys(ID serial, code int, primary key(ID, code));

        TRUNCAR TABLAS
        **************

        truncate table sols_hours_with_data;
        truncate table validity_checks;
        truncate table validity_checks_parameters;
        truncate table sols_checked;
        truncate table sol_keys;

        BORRAR TABLAS
        *************

        drop table sols_hours_with_data;
        drop table validity_checks;
        drop table validity_checks_parameters;
        drop table sols_checked;
        drop table sol_keys;      
        
        JSON APLANADO
        *************
       
        select 
                d.code, d.type, d.value, coalesce(vc.isvalid, false) as isvalid, par.value as sol_hours_required
        from
                sols_hours_with_data d, 
                validity_checks vc, 
                sols_checked sc, 
                validity_checks_parameters par
        where 
                vc.code = d.code and 
                vc.code = sc.code
        order by 1,2,3 asc;
        */
        function UpdateData($objPDO){
                $html = file_get_contents("https://api.nasa.gov/insight_weather/?api_key=ckBXkQefDG9WMWhBe0i2c0jew7wm9gqK1914ItzS&feedtype=json&ver=1.0");
                $result = json_decode($html);

                $sol_keys = $result->sol_keys;
                $sol_hours_required = $result->validity_checks->sol_hours_required;
                $sols_checked = $result->validity_checks->sols_checked;

                foreach ($sols_checked as $sols_checked_object) {
                        $solsCheckedItem = new Sols_checked($objPDO);
                        $solsCheckedItem->setCode($sols_checked_object);
                        $solsCheckedItem->save();
                }

                foreach ($sol_keys as $sols_key_object) {
                        $solsKeyItem = new Sols_keys($objPDO);
                        $solsKeyItem->setCode($sols_key_object);
                        $solsKeyItem->save();
                }

                $validityParameters = new Validity_checks_parameters($objPDO);
                $validityParameters->setKey('sol_hours_required');
                $validityParameters->setValue($sol_hours_required);
                $validityParameters->save();

                foreach ($result->validity_checks as $key => $value) {
                        if ($key != 'sol_hours_required' && $key != 'sols_checked') {
                                // SOLS_HOURS_WITH_DATA

                                $atmosphere = $value->AT->sol_hours_with_data;
                                foreach ($atmosphere as $internalValue) {
                                        $atData = new Sols_hours_with_data($objPDO);
                                        $atData->setCode($key);
                                        $atData->setType('AT');
                                        $atData->setValue($internalValue);

                                        $atData->save();
                                }

                                $horizontalWind = $value->HWS->sol_hours_with_data;
                                foreach ($horizontalWind as $internalValue) {
                                        $hwsData = new Sols_hours_with_data($objPDO);
                                        $hwsData->setCode($key);
                                        $hwsData->setType('HWS');
                                        $hwsData->setValue($internalValue);

                                        $hwsData->save();
                                }

                                $pressure = $value->PRE->sol_hours_with_data;
                                foreach ($pressure as $internalValue) {
                                        $preData = new Sols_hours_with_data($objPDO);
                                        $preData->setCode($key);
                                        $preData->setType('PRE');
                                        $preData->setValue($internalValue);

                                        $preData->save();
                                }

                                $windDirection = $value->WD->sol_hours_with_data;
                                foreach ($windDirection as $internalValue) {
                                        $wdData = new Sols_hours_with_data($objPDO);
                                        $wdData->setCode($key);
                                        $wdData->setType('WD');
                                        $wdData->setValue($internalValue);

                                        $wdData->save();
                                }

                                // VALIDITY_CHECKS

                                $validityCheck = new Validity_Checks($objPDO);
                                $validityCheck->setCode($key);
                                $validityCheck->setType('AT');
                                $validityCheck->setIsValid($value->AT->valid);

                                $validityCheck->save();

                                $validityCheck = new Validity_Checks($objPDO);
                                $validityCheck->setCode($key);
                                $validityCheck->setType('HWS');
                                $validityCheck->setIsValid($value->HWS->valid);
                                
                                $validityCheck->save();

                                $validityCheck = new Validity_Checks($objPDO);
                                $validityCheck->setCode($key);
                                $validityCheck->setType('PRE');
                                $validityCheck->setIsValid($value->PRE->valid);
                                
                                $validityCheck->save();

                                $validityCheck = new Validity_Checks($objPDO);
                                $validityCheck->setCode($key);
                                $validityCheck->setType('WD');
                                $validityCheck->setIsValid($value->WD->valid);
                                
                                $validityCheck->save();
                        }
                }    
        }  
        
        UpdateData($objPDO);                  
?>



