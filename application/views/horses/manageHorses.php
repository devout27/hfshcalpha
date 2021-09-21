<div class="row">
    <div class="col-sm-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover no-wrap" id="dt-my-horses-list">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>                                
                                <th scope="col">Name</th>
                                <th scope="col">Stable</th>
                                <th scope="col">Born</th>
                                <th scope="col">Color</th>
                                <th scope="col">Breed</th>
                                <th scope="col">Gender</th>
                                <th scope="col">HS</th>
                                <th scope="col">FS</th>
                                <th scope="col">V/F</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- stables -->
    <div class="col-sm-12">
        <h2>Stables</h2>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover no-wrap" <? /*id="dt-horses-<?= $title ?> */ ?>>
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Boarding</th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach((array)$stables AS $stable): ?>
                                <tr>
                                    <td><a href="/city/stable/<?= $stable['stables_id'] ?>"><?= $stable['stables_name'] ?></a></td>
                                    <td><?= $stable['stables_boarding_public'] ? '$'.$stable['stables_boarding_fee'] : 'Private' ?></td>
                                </tr>
                            <? endforeach; ?>
                            <? if(!count($stables)): ?>
                                <tr><td class="text-center"colspan="100%">No stables</td></tr>
                            <? endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--stables end-->
</div>