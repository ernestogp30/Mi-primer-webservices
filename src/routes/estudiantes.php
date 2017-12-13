<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Obtener todos los estudiantes

$app->get('/api/estudiantes', function(Request $request, Response $response){
	//echo "Estudiantes";
	$sql = "select * from estudiante";

	try{
		// Obtener el objeto DB 
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiantes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        print_r($estudiantes);
        //echo json_encode($estudiantes);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un estudiante por no de control
$app->get('/api/estudiantes/{nocontrol}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('nocontrol');

    $sql = "SELECT * FROM estudiante WHERE No_control = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $estudiante = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //print_r($estudiante);
        echo json_encode($estudiante);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un estudiante
$app->post('/api/estudiantes/add', function(Request $request, Response $response){
    $nocontrol = $request->getParam('nocontrol');
    $nombre = $request->getParam('nombre');
    $apellidop = $request->getParam('apellidop');
    $apellidom = $request->getParam('apellidom');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = "INSERT INTO estudiante (No_control, nombre_estudiante, apellido_paterno_estudiante, apellido_materno_estudiante, semestre, carrera_clave_carrera) VALUES (:nocontrol, :nombre, :apellidop, :apellidom, :semestre, :carrera_clave)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':nocontrol',      $nocontrol);
        $stmt->bindParam(':nombre',         $nombre);
        $stmt->bindParam(':apellidop',      $apellidop);
        $stmt->bindParam(':apellidom',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar estudiante
$app->put('/api/estudiantes/update/{nocontrol}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('nocontrol');
    $nombre = $request->getParam('nombre');
    $apellidop = $request->getParam('apellidop');
    $apellidom = $request->getParam('apellidom');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave');

    $sql = "UPDATE estudiante SET
                No_control = :nocontrol,
                nombre_estudiante     = :nombre,
                apellido_paterno_estudiante   = :apellidop,
                apellido_materno_estudiante  = :apellidom,
                semestre                = :semestre,
                carrera_clave_carrera          = :carrera_clave
            WHERE No_control = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':nocontrol',      $nocontrol);
        $stmt->bindParam(':nombre',         $nombre);
        $stmt->bindParam(':apellidop',      $apellidop);
        $stmt->bindParam(':apellidom',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave',  $carrera_clave);

        $stmt->execute();

        echo '{"notice": {"text": "Estudiante actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar estudiante
$app->delete('/api/estudiantes/delete/{nocontrol}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('nocontrol');

    $sql = "DELETE FROM estudiante WHERE No_control = $nocontrol";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Estudiante eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


$app2 = new \Slim\App;

// Obtener todos los instructores
$app->get('/api/instructores', function(Request $request, Response $response){
    //echo "Estudiantes";
    $sql = "select * from instructor";

    try{
        // Obtener el objeto DB 
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $instructor= $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //print_r($carrera);
        echo json_encode($instructor);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Obtener instructores mediante su RFC
$app->get('/api/instructores/{RFC}', function(Request $request, Response $response){
    $rfc = $request->getAttribute('RFC');

    $sql = "SELECT * FROM instructor WHERE rfc_instructor = '" . $rfc ."'";;

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $carrera = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        print_r($carrera);
        //echo json_encode($carrera);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar instructores
$app->post('/api/instructores/add', function(Request $request, Response $response){
    $RFC = $request->getParam('rfci');
    $nombreInstructor= $request->getParam('nombrei');
    $apepaterno= $request->getParam('apai');
    $apematerno= $request->getParam('amai');
    $act= $request->getParam('acti');


    $sql = "INSERT INTO instructor (rfc_instructor, nombre_instructor, apellido_paterno_instructor, apellido_materno_instructor, act_complementaria_clave_act) VALUES (:rfci, :nombrei, :apai, :amai, :acti)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfci',      $RFC);
        $stmt->bindParam(':nombrei',         $nombreInstructor);
        $stmt->bindParam(':apai',         $apepaterno);
        $stmt->bindParam(':amai',         $apematerno);
        $stmt->bindParam(':acti',         $act);

        $stmt->execute();

        echo '{"notice": {"text": "Instructor agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar instructor
$app->put('/api/instructores/update/{rfci}', function(Request $request, Response $response){
    $RFC = $request->getParam('rfci');
    $nombreInstructor = $request->getParam('nombrei');
    $apepaterno = $request->getParam('apai');
    $apematerno = $request->getParam('apmai');
    $act = $request->getParam('acti');
   

    $sql = "UPDATE instructor SET
                rfc_instructor = :rfci,
                nombre_instructor     = :nombrei,
                apellido_paterno_instructor   = :apai,
                apellido_materno_instructor  = :amai,
                act_complementaria_clave_act              = :acti
          
            WHERE rfc_instructor ='" . $RFC ."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfci',      $RFC);
        $stmt->bindParam(':nombrei',         $nombreInstructor);
        $stmt->bindParam(':apai',      $apepaterno);
        $stmt->bindParam(':amai',      $apematerno);
        $stmt->bindParam(':acti',       $act);
    

        $stmt->execute();

        echo '{"notice": {"text": "Instructor actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
//Eliminar Instructor
$app->delete('/api/instructores/delete/{rfci}', function(Request $request, Response $response){
    $RFC = $request->getAttribute('rfci');

    $sql = "DELETE FROM instructor WHERE rfc_instructor = '" . $RFC ."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Instructor eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

$app3 = new \Slim\App;

// Obtener todos los institutos
$app->get('/api/institutos', function(Request $request, Response $response){
    //echo "Estudiantes";
    $sql = "select * from instituto";

    try{
        // Obtener el objeto DB 
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $instituto= $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //print_r($carrera);
        echo json_encode($instituto);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener materias mediante sus claves
$app->get('/api/institutos/{claveinst}', function(Request $request, Response $response){
    $Institute = $request->getAttribute('claveinst');

    $sql = "SELECT * FROM instituto WHERE clave_instituto = '" . $Institute ."'";;

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $escuela = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        print_r($escuela);
        //echo json_encode($carrera);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar institutos
$app->post('/api/institutos/add', function(Request $request, Response $response){
    $ClaveInstituto = $request->getParam('claveinstituto');
    $nombreInstituto= $request->getParam('nombreinstituto');
   


    $sql = "INSERT INTO instituto (clave_instituto, nombre_instituto) VALUES (:claveinstituto, :nombreinstituto)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':claveinstituto',      $ClaveInstituto);
        $stmt->bindParam(':nombreinstituto',         $nombreInstituto);
       

        $stmt->execute();

        echo '{"notice": {"text": "Instituto agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar institutos
$app->put('/api/institutos/update/{clavesita}', function(Request $request, Response $response){
    $ClaveInstituto = $request->getParam('clavesita');
    $nombreInstituto = $request->getParam('nombreI');

    $sql = "UPDATE instituto SET
                clave_instituto = :clavesita,
                nombre_instituto    = :nombreI
           
          
            WHERE clave_instituto  ='" . $ClaveInstituto ."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clavesita',      $ClaveInstituto);
        $stmt->bindParam(':nombreI',         $nombreInstituto);
     
    

        $stmt->execute();

        echo '{"notice": {"text": "Instituto actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
//Eliminar InstItutos
$app->delete('/api/institutos/delete/{clavesita}', function(Request $request, Response $response){
    $ClaveInstituto = $request->getAttribute('clavesita');

    $sql = "DELETE FROM instituto WHERE clave_instituto = '" . $ClaveInstituto ."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Instituto eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

$app4 = new \Slim\App;
// Obtener todos los departamentos

$app->get('/api/departamentos', function(Request $request, Response $response){
    //echo "Departamentos";

    $sql = "select * from departamento";

    try{
        // Get DB Object
        $db = new db();
        // Connect

        $db = $db->connect();

        $stmt = $db->query($sql);
        $departamentos = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo json_encode($departamentos);

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }


});
// Obtener un departamento por clave
$app->get('/api/departamentos/{clavedepa}', function(Request $request, Response $response){
    $clavedepa = $request->getAttribute('clavedepa');

    $sql = "SELECT * FROM departamento WHERE ClaveDepa = $clavedepa";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $departamento = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($departamento);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un departamento
$app->post('/api/departamentos/add', function(Request $request, Response $response){
    $clavedepa = $request->getParam('clavedepa');
    $nombredepa = $request->getParam('nombredepa');
    $rfc = $request->getParam('rfc');
   

    $sql = "INSERT INTO departamento (ClaveDepa, nombre_depa, trabajador_rfc_trabajador) VALUES (:clavedepa, :nombredepa, :rfc)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clavedepa',      $clavedepa);
        $stmt->bindParam(':nombredepa',         $nombredepa);
         $stmt->bindParam(':rfc',         $rfc);
        

        $stmt->execute();

        echo '{"notice": {"text": "departamento agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar departamento
$app->put('/api/departamentos/update/{clavedepa}', function(Request $request, Response $response){
    $clavedepa = $request->getParam('clavedepa');
    $nombredepa = $request->getParam('nombredepa');
    $rfc = $request->getParam('rfc');

   $sql = "UPDATE departamento SET
                ClaveDepa           = :clavedepa,
                nombre_depa    = :nombredepa,
                trabajador_rfc_trabajador      = :rfc
                
            WHERE ClaveDepa = $clavedepa";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clavedepa',      $clavedepa);
        $stmt->bindParam(':nombredepa',         $nombredepa);
        $stmt->bindParam(':rfc',         $rfc);
       
 $stmt->execute();

        echo '{"notice": {"text": "departamento actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar estudiante
$app->delete('/api/departamentos/delete/{clavedepa}', function(Request $request, Response $response){
    $ClaveDepto = $request->getAttribute('clavedepa');

    $sql = "DELETE FROM departamento WHERE ClaveDepa = $ClaveDepto";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Departamento eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

$app5 = new \Slim\App;


// Obtener todas las actividades complementarias

$app->get('/api/actividades', function(Request $request, Response $response){
    //echo "Carreras";

    $sql = "select * from act_complementaria";

    try{

        // Get DB Object
        $db = new db();
        // Connect

        $db = $db->connect();

        $stmt = $db->query($sql);
        $actividades = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo json_encode($actividades);

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';


    }


});

// Obtener una actividad por clave
$app->get('/api/actividades/{clave_Act}', function(Request $request, Response $response){
    $clave_Act = $request->getAttribute('clave_Act');

    $sql = "SELECT * FROM act_complementaria WHERE clave_act = $clave_Act";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $act_complementaria = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($act_complementaria);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar una actividad
$app->post('/api/actividades/add', function(Request $request, Response $response){
    $clave_Act = $request->getParam('clave_Act');
    $nombreAct = $request->getParam('nombreAct');
   

    $sql = "INSERT INTO act_complementaria (clave_act, nombre_act) VALUES (:clave_Act, :nombreAct)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_Act',      $clave_Act);
        $stmt->bindParam(':nombreAct',         $nombreAct);
        

        $stmt->execute();

        echo '{"notice": {"text": "Actividad agregada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar actividad
$app->put('/api/actividades/update/{clave_Act}', function(Request $request, Response $response){
    $clave_Act = $request->getParam('clave_Act');
    $nombreAct = $request->getParam('nombreAct');
   

    $sql = "UPDATE act_complementaria SET
                clave_act             = :clave_Act,
                nombre_act     = :nombreAct
                
            WHERE clave_act = $clave_Act";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_Act',      $clave_Act);
        $stmt->bindParam(':nombreAct',         $nombreAct);
       

        $stmt->execute();

        echo '{"notice": {"text": "actividad actualizada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//Eliminar Departamento
$app->delete('/api/actividades/delete/{acti}', function(Request $request, Response $response){
    $ClaveAct = $request->getAttribute('clavesita');

    $sql = "DELETE FROM act_complementaria WHERE clave_Act = $ClaveAct";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Instituto eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});