<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/site/index" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">VCI-EMTS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $assetDir ?>/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    <?php
                    if (!Yii::$app->user->isGuest) {
                        $memberDetail = \app\models\Member::findOne(['member_id' => Yii::$app->user->identity->member_id]);
                        echo $memberDetail->firstname . ' ' . $memberDetail->lastname;

                        // $sector  = $this->sector;
                    }
                    else{
                        echo 'General Public';
                    }
                    ?>

                </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php 
                if(!Yii::$app->user->isGuest ){
                    switch(Yii::$app->user->identity->user_type){
                        case 1: echo $this->render('sidebar-main-super-admin'); break;
                        case 2: echo $this->render('sidebar-main-publisher'); break;
                        case 3: echo $this->render('sidebar-main-tabulator'); break;
                        case 4: echo $this->render('sidebar-main-event-manager'); break;
                        case 5: echo $this->render('sidebar-main-content-manager'); break;
                    }
                    
                }
                else{
                    echo $this->render('sidebar-main-public'); 
                }
            
            ?>
            
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
 