<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Usuario;
use app\models\LoginForm;
use app\models\Alerta;


class AuthController extends Controller
{
    /**
     * Configura el comportamiento del controlador
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'registrar'],
                        'roles' => ['?'], // Invitados
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'usuario', 'moderador', 'administrador', 'sysadmin', 'gestionar-alertas'],
                        'roles' => ['@'], // Usuarios autenticados
                    ],
                    [
                        'allow' => true,
                        'actions' => ['moderador'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role === 'moderador';
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['administrador'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role === 'administrador';
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['sysadmin'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role === 'sysadmin';
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionRegistrar()
    {
        $model = new Usuario();
    
        if ($model->load(Yii::$app->request->post())) {
            $model->role = 'normal';  // Rol por defecto para usuarios registrados
            $model->password = Yii::$app->security->generatePasswordHash($model->password1); // Contraseña cifrada
            $model->register_date = date('Y-m-d H:i:s');
            $model->confirmed = 1;
    
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
                return $this->redirect(['auth/login']);
            } else {
                Yii::$app->session->setFlash('error', 'Error al registrar el usuario.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Error en el formulario.');
        }
    
        return $this->render('//site/registrar', ['model' => $model]);
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect($this->getRedirectUrl(Yii::$app->user->identity->role));
        }

        return $this->render('//site/login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['site/index']);
    }

    public function actionUsuario()
    {
        return $this->render('//usuario/index');
    }

    public function actionModerador()
    {
        return $this->render('//moderador/index');
    }

    public function actionAdministrador()
    {
        return $this->render('//admin/index');
    }

    public function actionSysadmin()
    {
        return $this->render('//sysadmin/index');
    }

    public function actionGestionarAlertas()
    {
        $usuarioId = Yii::$app->user->identity->id;

        // Listar alertas del usuario actual
        $alertas = Alerta::listarPorUsuario($usuarioId);

        // Crear una nueva alerta si se recibe un POST
        $nuevaAlerta = new Alerta();
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $data['usuario_id'] = $usuarioId; // Asociar al usuario actual
            if ($nuevaAlerta->crearAlerta($data)) {
                Yii::$app->session->setFlash('success', 'Alerta creada correctamente.');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Error al crear la alerta: ' . json_encode($nuevaAlerta->getErrors()));
            }
        }

        return $this->render('//site/gestionar_alertas', [
            'alertas' => $alertas,
            'nuevaAlerta' => $nuevaAlerta,
        ]);
    }

    private function getRedirectUrl($role)
    {
        switch ($role) {
            case 'usuario':
                return ['auth/usuario'];
            case 'moderador':
                return ['auth/moderador'];
            case 'administrador':
                return ['auth/administrador'];
            case 'sysadmin':
                return ['auth/sysadmin'];
            default:
                return ['site/index'];
        }
    }
}
