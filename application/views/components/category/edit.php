<div class="container-fluid">
    <div class="row">
     <?php  echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                   <h1>Edit Category</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php 
                $attr=array('class'=>"form-horizontal"); 
                echo form_open(site_url('category/category/edit/'.$id), $attr);
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Category Name <span class="req">&nbsp;*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="category"  required value="<?php echo filter($category[0]->category); ?>" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label"> Department <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="department_id" class="form-control" required>
                            <option value="">Select Department </option>
                            <?php if(!empty($departmentList)){
                                foreach($departmentList as $item){ 
                                    echo '<option value="'. $item->id .'" '. ($item->id == $category[0]->department_id ? 'selected' : '')  .'>'. $item->department_name .'</option>';
                                }
                            }?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Update" class="btn btn-primary pull-right">
                    </div>
                </div>
               <?php  echo form_close();?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

