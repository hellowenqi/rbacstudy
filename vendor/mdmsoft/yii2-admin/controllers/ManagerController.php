<?php

namespace mdm\admin\controllers;

use Yii;
//use mdm\admin\models\form\Login;
//use mdm\admin\models\form\PasswordResetRequest;
//use mdm\admin\models\form\ResetPassword;
//use mdm\admin\models\form\ChangePassword;
use mdm\admin\models\form\CreateSchoolManager;             //$$
use mdm\admin\models\Manager;                              //$$
use mdm\admin\models\searchs\Manager as ManagerSearch;  //$$
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\base\UserException;
use yii\mail\BaseMailer;

/**
 * User controller
 */
class ManagerController extends Controller
{
    private $_oldMailPath;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['signup', 'reset-password', 'login', 'request-password-reset'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'actions' => ['logout', 'change-password', 'index', 'view', 'delete', 'activate'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'logout' => ['post'],
                    'activate' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (Yii::$app->has('mailer') && ($mailer = Yii::$app->getMailer()) instanceof BaseMailer) {
                /* @var $mailer BaseMailer */
                $this->_oldMailPath = $mailer->getViewPath();
                $mailer->setViewPath('@mdm/admin/mail');
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if ($this->_oldMailPath !== null) {
            Yii::$app->getMailer()->setViewPath($this->_oldMailPath);
        }
        return parent::afterAction($action, $result);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ManagerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Login
     * @return string
     */
//    public function actionLogin()
//    {
//        if (!Yii::$app->getUser()->isGuest) {
//            return $this->goHome();
//        }
//
//        $model = new Login();
//        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
//            return $this->goBack();
//        } else {
//            return $this->render('login', [
//                    'model' => $model,
//            ]);
//        }
//    }

    /**
     * Logout
     * @return string
     */
//    public function actionLogout()
//    {
//        Yii::$app->getUser()->logout();
//
//        return $this->goHome();
//    }

    /**
     * Signup new user
     * @return string
     */
    public function actionSignup()
    {
        $model = new CreateSchoolManager();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ( $model->signup()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('signup', [
                'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           // return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Request reset password
     * @return string
     */
//    public function actionRequestPasswordReset()
//    {
//        $model = new PasswordResetRequest();
//        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
//            if ($model->sendEmail()) {
//                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
//
//                return $this->goHome();
//            } else {
//                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
//            }
//        }
//
//        return $this->render('requestPasswordResetToken', [
//                'model' => $model,
//        ]);
//    }

    /**
     * Reset password
     * @return string
     */
//    public function actionResetPassword($token)
//    {
//        try {
//            $model = new ResetPassword($token);
//        } catch (InvalidParamException $e) {
//            throw new BadRequestHttpException($e->getMessage());
//        }
//
//        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->resetPassword()) {
//            Yii::$app->getSession()->setFlash('success', 'New password was saved.');
//
//            return $this->goHome();
//        }
//
//        return $this->render('resetPassword', [
//                'model' => $model,
//        ]);
//    }

    /**
     * Reset password
     * @return string
     */
//    public function actionChangePassword()
//    {
//        $model = new ChangePassword();
//        if ($model->load(Yii::$app->getRequest()->post()) && $model->change()) {
//            return $this->goHome();
//        }
//
//        return $this->render('change-password', [
//                'model' => $model,
//        ]);
//    }

    /**
     * Activate new user
     * @param integer $id
     * @return type
     * @throws UserException
     * @throws NotFoundHttpException
     */
    public function actionActivate($id)
    {
        /* @var $user User */
        $manager = $this->findModel($id);
        if ($manager->status == Manager::STATUS_INACTIVE) {
            $manager->status = Manager::STATUS_ACTIVE;
            if ($manager->save()) {
                return $this->goHome();
            } else {
                $errors = $manager->firstErrors;
                throw new UserException(reset($errors));
            }
        }
        return $this->goHome();
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Manager::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
