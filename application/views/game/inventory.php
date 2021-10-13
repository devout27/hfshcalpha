<? if($profile['players_pending']): ?>
	<h2>Player is pending.</h2>
<? elseif($profile['players_deleted']): ?>
	<h2>Player has been deleted.</h2>
<? endif; ?>
<? if((($profile['players_pending'] || $profile['players_deleted']) AND $player['privileges']['privileges_members']) OR (!$profile['players_pending'] AND !$profile['players_deleted'])): ?>
  <div class="text-right mb-3 ">
      <a class="btn btn-primary" href="<?=$sub_page_url?>" title="Edit"><?=$sub_page_title?></a>
  </div>                  
<div class="row">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-body">          
            
          <? $this->load->view('partials/inventory'); ?>
        </div>
      </div>
    </div>
</div>

<? endif; ?>