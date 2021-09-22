<div class="row align-items-center">
        <div class="col-md-9">
            <div class="dark text-color">
                <div class="user-p-img" style="background-image: url(<?= $member['players_banner']  ? $member['players_banner'] : USER_DEFAULT_IMAGE;?>);"></div>
                <div>
                    <h4><?php echo ucfirst($member['players_nickname']);?>  <?=$member['players_admin'] ? '<i class="las la-certificate"></i>' : ''?></h4>
                    <h6><?php echo $member['players_email'];?></h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="user-status text-right">
                <?php 
                    if($member['players_pending']==1)
                    {
                        $my_status = '<a class="mr-2" href="'.BASE_URL.$class_name.$sub_page_url_active_inactive."/".$member['players_id']."/1/".$status.'"><button type="submit" class="custom-active px-3"><i class="lar la-check-circle"></i></button></a>';
                        $my_status .= '<a href="'.BASE_URL.$class_name.$sub_page_url_active_inactive."/".$v['players_id']."/0/".$status.'"><button type="submit" class="custom-inactive px-3"><i class="lar la-times-circle"></i></button></a>';
                    }else
                    {
                        $my_status = ($member['players_pending']==0) ? '<button type="submit" class="custom-active">Accepted</button>' : '<button type="submit" class="custom-inactive">Rejected</button>';
                    }                    
                    echo $my_status;
                ?>                
            </div>
        </div>
    </div>
</div>