<div class="pt-3 pb-5 "><hr>
    <form method="post" class="<?php echo $type == "vet" ? "vet-container" : "farrier-container"?> d-none" action="/manage-horses-care/<?php echo $type; ?>">
        <div class="row">            
            <div class="row form-group py-3">
                <label class="col-sm-12 col-form-label" for="appointment">Appointment Type</label>
                <div class="col-sm-12">
                    <select class="form-control" name="appointment" id="appointment">
                        <option value="" selected="selected">-- Choose --</option>
                        <?php if($type == "vet"): ?>
                            <option value="Required Annual Care">Required Annual Care $300.00 for each Horse.</option>
                            <option value="Disaster Care Package">Disaster Care Package $2000.00 for each Horse.</option>
                        <?php else: ?>
                            <option value="Basic Care">Basic Care - $450/year for each Horse.</option>
                            <option value="Performance/Race Package">Performance/Race Package - $1,000/year for each Horse.</option>
                        <?php endif; ?>
                    </select>
                    <div class="form-error pull-right"><?php echo @$errors['appointment']; ?></div>
                </div>                    
            </div>
        </div>
        <div class="col-md-12 dynamic-form-data py-3"></div>
        <div class="row justify-content-center">
            <div class="col-md-3"><button class="btn btn-primary" type="submit">Save changes</button></div>
        </div>        
    </form>
    <p class='text-center font-weight-bold data-not-found d-none'>No horses available for <?php echo ucFirst($type); ?>.</p>        
</div>