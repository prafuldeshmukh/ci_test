<div class="container">
	<div class="row">
		<div class="col-md-12">
			<!-- <div class="page-header">
				<h1>Login success!</h1>
			</div> -->
			<p>You are now logged in.</p>
		</div>
	</div><!-- .row -->
</div><!-- .container -->	

<div class="container">
	<div class="row">
		<div class="col-md-12">
		<?php
if($this->session->flashdata('msg')){
echo $this->session->flashdata('msg');
} 
?>
		<div><h4>List Of Blogs</h4>
<a href="<?= site_url('blogs/create') ?>" type="button" class="btn btn-success">Create Blogs</a>
<div class="clearfix"></div><br>
</div>
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Acftions</th>
                
            </tr>
        </thead>
        <tbody> 
           
        <?php foreach($blogs as $blog ){?>
            <tr>
                <td><?php echo $blog->title;?></td>
                <td><?php echo $blog->description;?></td>
                <td><?php echo $blog->created_date;?></td>
                <td><?php echo $blog->updated_date;?></td>
                <td>
                <a href="<?= site_url('blogs/edit') ?>/<?php echo $this->blogs_model->seo_url($blog->title);?>" type="button" class="btn btn-default">Edit</a>
                <a  href="<?= site_url('blogs/delete') ?>/<?php echo $blog->id;?>" onclick="return confirm('Are you sure want to delete?.');" type="button" class="btn btn-danger">Delete</a></td>               
            </tr>
            <?php }?>   
                 
        </tbody>
    </table>
    <?php if(empty($blogs)){?>  
    No data avaliable
    <?php }?>
    </div>
   </div>
   </div> 