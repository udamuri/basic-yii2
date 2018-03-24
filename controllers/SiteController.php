<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\CategoryForm;
use app\models\TransactionForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionTransaksi()
    {
        $model = new TransactionForm;
        $startdate = '';
        if(isset($_GET['startdate']))
        {
            $startdate =  $_GET['startdate'];
        }
        
        $enddate = '';
        if(isset($_GET['enddate']))
        {
            $enddate =  $_GET['enddate'];
        }
        
        $query = (new \yii\db\Query())
                    ->select([
                        'tt.transaction_id',
                        'tt.category_id',
                        'tc.category_name',
                        'tc.category_status',
                        'tt.transaction_desc',
                        'tt.transaction_date',
                        'tt.transaction_amount',
                    ])
                    ->from('tbl_transactions tt')
                    ->leftJoin('tbl_category tc', 'tc.category_id = tt.category_id');
        
        $isDate = $model->isValidDateTime($startdate) && $model->isValidDateTime($enddate) ? true : false;
        if($isDate && $startdate !== '' && $enddate !== '')
        {
            $query->where('tt.transaction_date between  "'.$startdate.'" AND "'.$enddate.'" ');
        } else {
            $query->where(['year(tt.transaction_date)'=>date('Y')])
                  ->andWhere(['month(tt.transaction_date)'=>date('m')]);
            $startdate = '';
            $enddate = '';
        }
        
        $countQuery = clone $query;
        $pageSize = 10;
        $pages = new Pagination([
                'totalCount' => $countQuery->count(), 
                'pageSize'=>$pageSize
            ]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['transaction_id'=>SORT_DESC])
            ->all();
            
        return $this->render('transactions', [
            'models' => $models,
            'pages' => $pages,
            'offset' =>$pages->offset,
            'page' =>$pages->page,
            'startdate' =>$startdate,
            'enddate' =>$enddate,
        ]);
    }
    
    /**
     * Displays Tambah Transaksi.
     *
     * @return Response|string
     */
    public function actionTambahTransaksi()
    {
        $model = new TransactionForm;
        
        if ($model->load(Yii::$app->request->post())) {
            if ($menu = $model->create()) {
                Yii::$app->session->setFlash('success', "Berhasil Menambahkan Transaksi Baru");
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl.'site/transaksi');
            }
        }

        return $this->render('create_transaction', [
            'model' => $model,
        ]);
    }
    
    /**
     * Displays Ganti Transaksi.
     *
     * @return Response|string
     */
    public function actionGantiTransaksi($id)
    {
        $model = new TransactionForm;
        $_model = $model->getTransaction($id);
   
        if($_model)
        {
            if ($model->load(Yii::$app->request->post())) {             
                if ($menu = $model->update($id)) {
                    Yii::$app->session->setFlash('success', "Sukser merubah Transaksi");
                    return $this->redirect(Yii::$app->homeUrl.'site/transaksi');
                }
            }
            return $this->render('update_transaction', [
                'model' => $model,
                '_model' => $_model,
            ]);
        }
        else
        {
            return $this->redirect(Yii::$app->homeUrl.'site/kategori');
        }
    }
    
    /**
     * Ganti Kategori action.
     *
     * @return Response
     */
    public function actionHapusTransaksi($id)
    {
        $model = new TransactionForm;

        if($model->delete($id))
        {
            Yii::$app->session->setFlash('success', "Sukser menghapus transaksi");
            return $this->redirect(Yii::$app->homeUrl.'site/transaksi');
        }
        else
        {
            Yii::$app->session->setFlash('error', "gagal menghapus transaksi");
            return $this->redirect(Yii::$app->homeUrl.'site/transaksi');
        }
    }
    
    /**
     * Display Kategori
     * 
     * @return string
     */
    public function actionKategori()
    {
        $search = '';
        if(isset($_GET['search']))
        {
            $search =  strtolower(trim(strip_tags($_GET['search'])));
        }
        
        $query = (new \yii\db\Query())
                    ->select([
                        'tc.category_id',
                        'tc.category_name',
                        'tc.category_status'
                    ])
                    ->from('tbl_category tc');
                    
        if($search !== '')
        {
            $query->where('lower(category_name) LIKE "%'.$search.'%" ');
        }
        
        $countQuery = clone $query;
        $pageSize = 10;
        $pages = new Pagination([
                'totalCount' => $countQuery->count(), 
                'pageSize'=>$pageSize
            ]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['category_id'=>SORT_DESC])
            ->all();
            
        return $this->render('category', [
            'models' => $models,
            'pages' => $pages,
            'offset' =>$pages->offset,
            'page' =>$pages->page,
            'search' =>$search
        ]);
    }
    
    /**
     * Displays Tambah Kategori.
     *
     * @return Response|string
     */
    public function actionTambahKategori()
    {
        $model = new CategoryForm;
        
        if ($model->load(Yii::$app->request->post())) {
            if ($menu = $model->create()) {
                Yii::$app->session->setFlash('success', "Berhasil Menambahkan Kategori Baru");
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl.'site/kategori');
            }
        }

        return $this->render('create_category', [
            'model' => $model,
        ]);
    }
    
    /**
     * Displays Ganti Kategori.
     *
     * @return Response|string
     */
    public function actionGantiKategori($id)
    {
        $model = new CategoryForm;
        $_model = $model->getCategory($id);
   
        if($_model)
        {
            if ($model->load(Yii::$app->request->post())) {             
                if ($menu = $model->update($id)) {
                    Yii::$app->session->setFlash('success', "Sukser merubah kategori");
                    return $this->redirect(Yii::$app->homeUrl.'site/kategori');
                }
            }
            return $this->render('update_category', [
                'model' => $model,
                '_model' => $_model,
            ]);
        }
        else
        {
            return $this->redirect(Yii::$app->homeUrl.'site/kategori');
        }
    }
    
    /**
     * Ganti Kategori action.
     *
     * @return Response
     */
    public function actionHapusKategori($id)
    {
        $model = new CategoryForm;

        if($model->delete($id))
        {
            Yii::$app->session->setFlash('success', "Sukser menghapus kategori");
            return $this->redirect(Yii::$app->homeUrl.'site/kategori');
        }
        else
        {
            Yii::$app->session->setFlash('error', "gagal menghapus kategori");
            return $this->redirect(Yii::$app->homeUrl.'site/kategori');
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
