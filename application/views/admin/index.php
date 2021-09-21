<div class="row">
	<div class="col-md-12">
		<h3>General Info</h3>

		<p>Here's some basic information about being an Admin.</p>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<h3>Current Administrators</h3>

		<p>Here's a list of everyone and what they do!</p>

		<div class="row">
			<div class="col-sm-12">
				<table class="table table-sm table-hover w-100 no-wrap">
		    		<thead>
					<tr>
		    			<th>Player</th>
		    			<th>Privileges</th>
            			<? if($privileges['privileges_admin']): ?>
		    				<th></th>
		    			<? endif; ?>
					</tr>
					</thead>
					<tbody>
						<? foreach((array)$admins AS $a): ?>
						<tr>
							<td><a href="/game/profile/<?= $a['players_id'] ?>"><?= $a['players_nickname'] ?> #<?= $a['players_id'] ?></a><br/><small class="text-muted"><?= $a['players_last_active2'] ?></small></td>
							<td>
			              		<?= $a['privileges_admin'] ? 'Master Admin<br/>' : '' ?>
			              		<?= $a['privileges_news'] ? 'News Updates<br/>' : '' ?>
			              		<?= $a['privileges_members'] ? 'Member Management<br/>' : '' ?>
			              		<?= $a['privileges_horses'] ? 'Horse Management<br/>' : '' ?>
			              		<?= $a['privileges_adoption'] ? 'Adopt-a-thon<br/>' : '' ?>
			              		<?= $a['privileges_bank'] ? 'Bank<br/>' : '' ?>
			              		<?= $a['privileges_cabs'] ? 'CABs<br/>' : '' ?>
			              		<?= $a['privileges_events'] ? 'Events<br/>' : '' ?>
			              		<?= $a['privileges_articles'] ? 'Articles/Help<br/>' : '' ?>
			              	</td>
            				<? if($privileges['privileges_admin']): ?>
            					<td>
            						<a href="/admin/mods/edit/<?= $a['players_id'] ?>" class="btn btn-primary col-sm-12">Edit</a>
            					</td>
            				<? endif; ?>
						</tr>
						<? endforeach; ?>
					</tbody>
				</table>

            	<? if($privileges['privileges_admin']): ?>
					<div class="float-right">
						<a href="/admin/mods/add" class="btn btn-primary">Add Admin</a>
					</div>
            	<? endif; ?>
		    </div>
		</div><br/>

	</div>
</div>


<? if($privileges['privileges_members']): ?>
<div class="row">
	<div class="col-md-8">
		<h3> Members</h3>
		<p>All kinds of information about editing members: accept/reject apps</p>
	</div>
	<div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
            	<a href="/admin/members/applications"><?= count($pending_applications) ?> Pending Applications</a><br/>
            	<a href="/admin/members/deletions"><?= count($pending_deletions) ?> Pending Delete Requests</a><br/>
            	<a href="/admin/members/vets"><?= count($vets) ?> Vets</a><br/>
            	<a href="/admin/members/farriers"><?= count($farriers) ?> Farriers</a><br/>
            	<a href="/admin/members/adoptathon">Award Adoptathon Credits</a><br/>
            	<a href="/admin/members/log">Activity Log</a><br/>
            </div>
        </div>
    </div>
</div>
<? endif; ?>


<? if($privileges['privileges_horses']): ?>
<div class="row">
	<div class="col-md-8">
		<h3>Horses</h3>

		<p>All kinds of information about editing horses: confirm import, confirm export</p>
	</div>
	<div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
            	<a href="/admin/horses/register"><?= count($pending_horse_registration) ?> Pending Registrations</a><br/>
            	<a href="/admin/horses/breed"><?= count($pending_horse_breedings) ?> Pending Breedings</a><br/>
            	<a href="/admin/horses/import"><?= count($pending_horse_import) ?> Pending Imports</a><br/>
            	<a href="/admin/horses/export"><?= count($pending_horse_export) ?> Pending Exports</a><br/>
            	<a href="/admin/horses/search">Search Owner Logs</a><br/>
            	<a href="/admin/horses/breeds">Edit Breeds, etc.</a><br/>
            	<a href="/admin/horses/genes">Edit Genes</a><br/>
            	<a href="/admin/horses/genes/blueprints">Edit Gene Blueprints</a><br/>
            </div>
        </div>
    </div>
</div>
<? endif; ?>


<? if($privileges['privileges_bank']): ?>
<div class="row">
	<div class="col-md-8">
		<h3>Bank</h3>

		<p>Approve/deny loans & other accounts. View who is late on a loan. Search bank accounts</p>
	</div>
	<div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
            	<a href="/admin/bank/applications"><?= $pending_bank_applications ?> Pending Applications</a><br/>
            	<a href="/admin/bank/loans">View Late Loan Payments</a><br/>
            	<a href="/admin/bank/search">Search Bank Accounts</a><br/>
            	<a href="/admin/bank/search_transactions">Search Transactions</a><br/>
            	<a href="/admin/bank/transfer">Transfer Money</a><br/>

            </div>
        </div>
    </div>
</div>
<? endif; ?>



<? if($privileges['privileges_cabs']): ?>
<div class="row">
	<div class="col-md-8">
		<h3>CABs</h3>

		<p>Approve/deny CAB requests. You can deactivate a CAB by visiting that CAB's page</p>
	</div>
	<div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
            	<a href="/admin/cabs/pending"><?= count($pending_cabs_applications) ?> Pending CAB Applications</a>
            </div>
        </div>
    </div>
</div>
<? endif; ?>



<? if($privileges['privileges_events']): ?>
<div class="row">
	<div class="col-md-8">
		<h3>Events</h3>

		<p>Approve/deny event requests. Edit events. Edit Classlists</p>
	</div>
	<div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
            	<a href="/admin/events/pending"><?= count($pending_events) ?> Pending Events</a><br/>
            	<a href="/admin/events/classlists">Classlists</a>
            </div>
        </div>
    </div>
</div>
<? endif; ?>




<? if($privileges['privileges_stables']): ?>
<div class="row">
	<div class="col-md-8">
		<h3>Stables/Ideal Dreams</h3>

		<p>Manage Ideal Dreams</p>
	</div>
	<div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
            	<!--<a href="/admin/stables/pending"><?= count($pending_orders) ?> Pending Orders</a><br/>-->
            	<a href="/admin/stables/amenities">Amenities</a><br/>
            	<a href="/admin/stables/packages">Packages</a><br/>
            	<!--<a href="/admin/stables/land">Land for Sale</a><br/>-->
            	<!--<a href="/admin/stables/">Stables</a>-->
            </div>
        </div>
    </div>
</div>
<? endif; ?>




<? if($privileges['privileges_articles']): ?>
<div class="row">
	<div class="col-md-8">
		<h3>Articles</h3>

		<p>When you edit an article, there is no UNDO button! Be 100% sure you want to save your changes before you save them. Also, the editor loses formatting of HTML (when you use the Source option). Save your HTML locally and edit it locally. Then, update the HTML here by copying/pasting it from your local copy.</p>
	</div>
	<div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
            	<a href="/admin/articles/add">Add New Page</a><br/>
            	<? if($privileges['privileges_news']): ?>
            		<a href="/admin/news">News</a><br/>
            	<? endif; ?>
            	<? foreach((array)$articles AS $article): ?>
            		<a href="/admin/articles/<?= $article['articles_id'] ?>"><?= $article['articles_name'] ?></a><br/>
            	<? endforeach; ?>
            </div>
        </div>
    </div>
</div>
<? endif; ?>
