<?php
namespace app\models;

use Yii;
use rce\material\widgets\Menu as RCEmenu;

class Menu  
{
    static function getMenu() {
        $role = Yii::$app->user->identity->role ?? null;

        // Por defecto no visible
        $showDashboard = true;
        $showAdmin = false;
        $showUsuarios = false;
        $showUsuariosAll = false;
       

        // Ajustar visibilidad según rol
        if ($role == 'superadmin') {
            $showDashboard = true;
            $showAdmin = true;
            $showUsuarios = true;
            $showUsuariosAll = true;
           
        
        } elseif ($role == 'admin') {
            $showDashboard = true;
            $showAdmin = true;
            $showUsuarios = true;
           
        } elseif ($role == 'distribuidor') {

        } 

        $menu = RCEmenu::widget(
            [
                'items' => [
                    [ 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/site/index'], 'visible' => $showDashboard ],
                   
                    // Menu Admin
                    ['label' => 'Administrador', 'icon' => 'people', 'visible' => $showAdmin, 
                        'items' => [
                            ['label' => 'Usuario', 'icon' => 'person', 'url' => ['usuario/index'], 'visible' => $showUsuarios],
                            ['label' => 'Usuario/Contratos', 'icon' => 'person', 'url' => ['usuariocontrato/index'], 'visible' => $showUsuarios],
                            ['label' => 'All User', 'icon' => 'person', 'url' => ['usuario/indexall'], 'visible' => $showUsuariosAll],
                            //['label' => 'Empresas', 'icon' => 'business', 'url' => ['empresa/index']],
                    ]],
                 
                    // [ 'label' => 'Fuecs', 'icon' => 'assignment_turned_in', 'url' => ['/fuec/index'], 'visible' => $showFUEC ],

                    // // Menu Operaciones Contabilidad
                    // ['label' => 'Contabilidad', 'icon' => 'exposure', 'visible' => $showOperacionesContabilidad, 
                    //     'items' => [
                    //         ['label' => 'Aprobación', 'icon' => 'exposure', 'url' => ['contabilidad/no-aprobados'], 'visible' => $showOperacionesContabilidad],
                    //         ['label' => 'Vehículos ya aprobados', 'icon' => 'exposure', 'url' => ['contabilidad/index'], 'visible' => $showOperacionesContabilidad],
                    // ]],

                   
                    // // Menu Operaciones Empresa
                    // ['label' => 'Operaciones Internas', 'icon' => 'airport_shuttle', 'visible' => $showOperaciones, 
                    //     'items' => [
                    //         ['label' => 'Ejecutadas', 'icon' => 'assignment_ind', 'url' => ['operacion/internasejecutadas'], 'visible' => $showOperacionesNormal],
                    //         ['label' => 'Asignadas', 'icon' => 'assignment_turned_in', 'url' => ['operacion/internasaprobadas'], 'visible' => $showOperacionesNormal],
                    //        // ['label' => 'Solicitar', 'icon' => 'laptop_mac', 'url' => ['operacion/index'], 'visible' => $showOperacionesNormal],
                    //         ['label' => 'Solicitar', 'icon' => 'laptop_mac', 'url' => ['operacionsolicitud/indexallinternas'], 'visible' => $showOperacionesNormal],
                    //         //['label' => 'Fuec', 'icon' => 'airport_shuttle', 'url' => ['fuec/index'], 'visible' => $showOperacionesNormal],
                    // ]],

                    // // Menu Operaciones Externas
                    // ['label' => 'Operaciones Externas', 'icon' => 'assignment', 'visible' => $showOperacionesExternas, 
                    // 'items' => [
                    //     // Usuario Externo
                    //     ['label' => 'Ejecutadas', 'icon' => 'assignment_ind', 'url' => ['operacion/indexexternaejecutada'], 'visible' => $showOperacionesSolicitud],
                    //     ['label' => 'Asigndas', 'icon' => 'assignment_ind', 'url' => ['operacion/externasaprobadas'], 'visible' => $showOperacionesSolicitud],
                    //     ['label' => 'Solicitud', 'icon' => 'assignment_ind', 'url' => ['operacionsolicitud/index'], 'visible' => $showOperacionesSolicitud],

                    //     // Operativo
                    //     ['label' => 'Ejecutadas', 'icon' => 'assignment_ind', 'url' => ['operacion/indexexternaejecutada'], 'visible' => $showOperacionesSolicitudAll],
                    //     ['label' => 'Operaciones Asigndas', 'icon' => 'assignment', 'url' => ['operacion/externasaprobadas'], 'visible' => $showOperacionesNormal],
                    //     //['label' => 'Operaciones Asignadas', 'icon' => 'assignment', 'url' => ['operacion/indexexternaasinganda'], 'visible' => $showOperacionesNormal],
                    //     ['label' => 'Solicitudes', 'icon' => 'assignment_ind', 'url' => ['operacionsolicitud/indexall'], 'visible' => $showOperacionesSolicitudAll],
                        
                    // ]],

                    // // Menu Comercial
                    // ['label' => 'Comercial', 'icon' => 'local_mall', 'visible' => $showComercial, 
                    //     'items' => [
                    //         ['label' => 'Clientes', 'icon' => 'people_outline', 'url' => ['clientetemporal/index']],
                    //         ['label' => 'Empresas', 'icon' => 'business', 'url' => ['empresa/index']],
                    //         ['label' => 'Contrato', 'icon' => 'recent_actors', 'url' => ['contrato/index']],
                    //         // ya no se usa['label' => 'Consorcios/UnionesT.', 'icon' => 'person_pin', 'url' => ['consorciouniontemporal/index']],
                    //         // ['label' => 'Tipo Contrato', 'icon' => 'keyboard', 'url' => ['contratotype/index']],
                    //     ]],
                    
                    // // Menu Talento Humano
                    // ['label' => 'Talento Humano', 'icon' => 'perm_contact_calendar', 'visible' => $showTalentoHumano, 
                    //     'items' => [
                    //         ['label' => 'Conductor', 'icon' => 'contact_mail', 'url' => ['conductor/index']],
                    // ]],

                    // // Menu Recepción y Tramites
                    // ['label' => 'Recepción y Tramites', 'icon' => 'directions_bus', 'visible' => $showTramites, 
                    // 'items' => [
                    //     ['label' => 'Vehiculo', 'icon' => 'directions_car', 'url' => ['vehicle/index']],
                    //     ['label' => 'Marca y Línea', 'icon' => 'copyright', 'url' => ['brand/index']],
                    //     ['label' => 'Color', 'icon' => 'copyright', 'url' => ['color/index']],

                    // ]],

                    
                    
                ],
            ]
        );
        return $menu;
    }

}
