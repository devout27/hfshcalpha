<section class="content">
    <div class="container dashboard">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-red">
                    <div class="inner">
                        <h3 class="count-1"><?=$usersCount?></h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="las la-user-friends"></i>
                    </div>
                    <a href="<?=$BASE_URL_ADMIN?>members" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-black">
                    <div class="inner">
                        <h3 class="count-1"><?=$adminsCount?></h3>
                        <p>Super Admins</p>
                    </div>
                    <div class="icon">
                        <i class="las la-user-friends"></i>
                    </div>
                    <a href="<?=$BASE_URL_ADMIN?>members/superAdmins" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-red">
                    <div class="inner">
                        <h3 class="count-1"><?=$pendingUsersCount?></h3>
                        <p>Pending Members</p>
                    </div>
                    <div class="icon">
                        <i class="las la-user-friends"></i>
                    </div>
                    <a href="<?=$BASE_URL_ADMIN?>members/inactive" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-black">
                    <div class="inner">
                        <h3 class="count-1"><?=$acceptedUsersCount?></h3>
                        <p>Accepted Members</p>
                    </div>
                    <div class="icon">
                        <i class="las la-user-friends"></i>
                    </div>
                    <a href="<?=$BASE_URL_ADMIN?>members/active" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>            
            <!---->
        </div>
    </div>
</section>