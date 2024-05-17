<?php

$methodToUse = "";
class Persona {
    public $nombre = "Juan";
    public $apellido = "Perez";
    public $altura = 1.74;
    public $colorcabello = "Rojo";
    public $tipocabello = "Lacio";
    public $colorpiel = "Rojo";
    public $tallazapato = 42;
    public $colorojos = "Azul";
    public $peso = 74;
    public $contextura = "Delgada";
    public $usalentes = false;

    public function __call($name, $arguments) {
        $action = substr($name, 0, 3);
        switch ($action) {
            case 'get':
                $property = '' . strtolower(substr($name, 3));
                if(property_exists($this,$property)){
                    return $this->{$property};
                }else{
                    echo "PROPIEDAD SIN DEFINIR: ". $property;
                }
                break;
            case 'set': //Por ejemplo para usar con setNombre o setContextura, etc.
                $property = '' . strtolower(substr($name, 3));
                if(property_exists($this,$property)){
                    $this->{$property} = $arguments[0];
                }else{
                    echo "PROPIEDAD SIN DEFINIR: ". $property;
                }
                break;
            default:
                return false;
        }
    }
}

// Función para modificar una persona
// function modificar_persona($persona) {
//     // Mostrar la lista de atributos y obtener la elección del usuario
//     $atributos = [
//         "nombre",
//         "apellido",
//         "altura",
//         "colorcabello",
//         "tipocabello",
//         "colorpiel",
//         "tallazapato",
//         "colorojos",
//         "peso",
//         "contextura",
//         "usalentes",
//     ];

//     if ($_SERVER["REQUEST_METHOD"] == "POST") {
//         if (isset($_POST["atributo"]) && isset($_POST["nuevo_valor"])) {
//             $atributo_seleccionado = $_POST["atributo"];
//             $nuevo_valor = $_POST["nuevo_valor"];
    
//             // Validar el nuevo valor según el tipo de atributo
//             if ($atributo_seleccionado == "altura" || $atributo_seleccionado == "peso") {
//                 $nuevo_valor = (float) $nuevo_valor;
//             } elseif ($atributo_seleccionado == "usalentes") {
//                 $nuevo_valor = strtolower($nuevo_valor);
//             }
    
//             // Modificar el atributo de la persona
//             if (property_exists($persona, $atributo_seleccionado)) {
//                 $persona->{$atributo_seleccionado} = $nuevo_valor;
//                 echo "Atributo " . $atributo_seleccionado . " modificado exitosamente.";
//             } else {
//                 echo "El atributo seleccionado no existe en la persona.";
//             }
//         } else {
//             echo "Por favor selecciona un atributo y proporciona un nuevo valor.";
//         }
//     }
// }

$persona = new Persona();


$opcion = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $opcion = (int) $_POST["opcion"];

    if ($opcion == 1 && isset($_POST["nuevo_valor"]) && isset($_POST["atributo"])) {
        
        $persona_mod = new Persona();
        $nuevo_valor = $_POST["nuevo_valor"];
        $persona_mod->{"set". ucfirst($_POST["atributo"])}($nuevo_valor);

        $methodToUse = "set" . ucfirst($_POST["atributo"]);


        // echo "set". ucfirst($_POST["atributo"]);
        
        // $persona->setApellido("Lopez");
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Modificar Persona</title>
    
    <style>
        body {
            min-height: 100vh;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(60deg, #29323c 100%, #485563 0%);
        }
        .body {
            color: black;
            background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
            margin-top: 4rem;
            max-width: 600px;
            /* background-color: #e1e1e1; */
            margin: 0 auto;
            padding: 1rem;
            border-radius: 3%;
        }
        .datos_personas {
            max-width: 200px;
            text-align: left;
            margin: 0 auto;

        }
        .datos_personas > p {
            margin-top: 0px;
            margin-bottom: 10px;
        }
        /* Estilos para lso botones */
        input[type=submit] { 
            /* font-stretch: ultra-expanded; */
            font-weight: 600;
            text-transform: uppercase;
            padding: .6rem;
            border-radius: 20px;
            border: none;
            color: white;
            background-image: linear-gradient(to top, #0ba360 0%, #3cba92 100%);
            width: 110px;
        }
        .row {
            margin-top: 2rem;
            display: flex;
            justify-content: space-around;
            align-items: end;
        }
        .col {
            padding: .3rem;
            flex-basis: auto;
            border: 1px solid black
        }
    </style>
</head>
<body style="text-align: center;">
    <main style="margin-top: 3rem;">
        <h3>Metodo a usar:  <span style="font-weight: 200"><?= $methodToUse ?></span> </h3>
        <div class="body">

        
            <h1 style="margin: 1rem auto;">Modificar Persona</h1>
            <!-- Formualario de PHP -->
            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <label for="opcion">Accion:</label>
                <select name="opcion" id="opcion">
                    <option value="1">Modificar Persona</option>
                    <option value="2">Mostrar Persona</option>
                </select>
                <br><br>
                <?php if ($opcion == 1) { ?>
                    <label for="atributo">Atributo a modificar:</label>
                    <select required name="atributo" id="atributo">
                        <option>Seleccione un Atributo</option>
                        <option value="nombre">Nombre</option>
                        <option value="apellido">Apellido</option>
                        <option value="altura">Altura</option>
                        <option value="colorcabello">Color de cabello</option>
                        <option value="tipocabello">Tipo de cabello</option>
                        <option value="colorpiel">Color de piel</option>
                        <option value="tallazapato">Talla de zapato</option>
                        <option value="colorojos">Color de ojos</option>
                        <option value="peso">Peso</option>
                        <option value="contextura">Contextura</option>
                        <option value="usalentes">Con miopia</option>
                    </select>
                    <br><br>
                    <label for="nuevo_valor">Nuevo valor:</label>
                    
                <?php if ($opcion == 1) { ?>

                    <input required type="text" name="nuevo_valor" id="nuevo_valor">

                <?php } else { ?>
                    
                    <input type="text" name="nuevo_valor" id="nuevo_valor">

                <?php } ?>

                    <br><br>
                <?php } ?>
                <input type="submit" value="aceptar">
            </form>
            <div class="row">
                <div class="col" style="">
                    <h2>Datos de la Persona:</h2>
                    <div class="datos_personas">
                
                        <p><strong>Nombre:</strong> <?= $persona->nombre . " " . $persona->apellido; ?></p>
                        <p><strong>Altura:</strong> <?= $persona->altura; ?></p>
                        <p><strong>Color de Cabello:</strong> <?= $persona->colorcabello; ?></p>
                        <p><strong>Tipo de Cabello:</strong> <?= $persona->tipocabello; ?></p>
                        <p><strong>Color de Piel:</strong> <?= $persona->colorpiel; ?></p>
                        <p><strong>Talla de Zapato:</strong> <?= $persona->tallazapato; ?></p>
                        <p><strong>Color de Ojos:</strong> <?= $persona->colorojos; ?></p>
                        <p><strong>Peso:</strong> <?= $persona->peso; ?></p>
                        <p><strong>Contextura:</strong> <?= $persona->contextura; ?></p>
                        <p><strong>¿Usa lentes?:</strong> <?php
                        if($persona->usalentes == "true") {
                            echo "Si usa";
                        } else {
                            echo "No";
                        }
                        ?></p>
                       <?php // var_dump($persona); ?>
                    </div>
                </div>
                <?php if($persona_mod->nombre != "Juan") {
                    ?>
                <div class="col">
                    <h2>Datos de la Persona<br> Modificada:</h2>
                    <div class="datos_personas">
                
                        <p><strong>Nombre:</strong> <?= $persona_mod->nombre . " " . $persona_mod->apellido; ?></p>
                        <p><strong>Altura:</strong> <?= $persona_mod->altura; ?></p>
                        <p><strong>Color de Cabello:</strong> <?= $persona_mod->colorcabello; ?></p>
                        <p><strong>Tipo de Cabello:</strong> <?= $persona_mod->tipocabello; ?></p>
                        <p><strong>Color de Piel:</strong> <?= $persona_mod->colorpiel; ?></p>
                        <p><strong>Talla de Zapato:</strong> <?= $persona_mod->tallazapato; ?></p>
                        <p><strong>Color de Ojos:</strong> <?= $persona_mod->colorojos; ?></p>
                        <p><strong>Peso:</strong> <?= $persona_mod->peso; ?></p>
                        <p><strong>Contextura:</strong> <?= $persona_mod->contextura; ?></p>
                        <p><strong>¿Usa lentes?:</strong> <?php
                        if($persona_mod->usalentes == "true") {
                            echo "Si usa";
                        } else {
                            echo "No";
                        }
                        ?></p>
                       <?php // var_dump($persona); ?>
                    </div>
                </div>
                <?php } ?>
            </div>
    
    </div>
    </main>
</body>
</html>