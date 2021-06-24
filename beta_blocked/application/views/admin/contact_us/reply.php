<?php
$this->load->view('templates/headers/admin_header', $title);
?>
<style type="text/css">
	.modal-content table td {
		background-color: #121213;
	}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2></h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0);"><?php echo $this->lang->line('admin'); ?></a>
            </li>
            <li>
                <a href="<?php echo base_url('admin/contactUs'); ?>"><?php echo $this->lang->line('contact_us'); ?></a>
            </li>            
            <li class="active">
                <strong><?php echo $this->lang->line('reply'); ?></strong>
            </li>
        </ol>
    </div>
</div>
<div class="col-lg-12 block_form">	
	<form action="" method="post" accept-charset="utf-8" class="general_config well" enctype="multipart/form-data">
		<?php if(validation_errors() != '') { ?>
		<div class="alert alert-danger">
			<?php echo $this->lang->line('please_correct_your_information'); ?>
		</div>
		<?php } ?>        

	    <fieldset>
	    	<legend><i class="fa fa-send"></i> <?php echo $this->lang->line('send_reply_message_to_user'); ?></legend>

            <table class="table">
                <tr>
                    <th><?php echo $this->lang->line('name'); ?></th>
                    <td><?php echo $message['first_name'].' '.$message['last_name']; ?> </td>
                </tr>                
                <tr>
                    <th><?php echo $this->lang->line('message'); ?></th>
                    <td><?php echo $message['message']; ?> </td>
                </tr>
                <tr>
                    <th><?php echo $this->lang->line('attachment'); ?></th>
                    <td class="text-center"><?php if($message['attachment'] != '') { ?><a href="<?php echo base_url($message['attachment']); ?>" target="_blank" class="btn"><i class="fa fa-file-o"></i></a><?php } ?></td>
                </tr>
            </table>
            <hr/>

	    	<div class="form-group">
	    		<label class="control-label" for="message_title"><?php echo $this->lang->line('title'); ?></label>
				<div class="controls">
					<input type="text" id="message_title" placeholder="" class="form-control" name="message_title" value="<?php echo set_value('message_title'); ?>">
				</div>
				<?php echo form_error('message_title'); ?>
	    	</div>
	    	<div class="form-group">
	    		<label class="control-label" for="inputContent"><?php echo $this->lang->line('content'); ?></label>
				<div class="controls">
					<textarea id="inputContent" class="form-control" name="message_content"><?php echo set_value('message_content'); ?></textarea>
				</div>
				<?php echo form_error('message_content'); ?>
	    	</div>
	    </fieldset>
		<hr />

        <div>
        	<button type="button" class="btn btn-primary btn-save" onclick="showEmailTemplatePreview()"><i class="fa fa-eye"></i> <?php echo $this->lang->line('preview'); ?></button>

            <button type="submit" class="btn btn-primary btn-save pull-right"><i class="fa fa-check"></i> <?php echo $this->lang->line('send'); ?></button>
        </div>
	</form>
</div>

<!-- Email Preview Model-->
<div id="newsPreviewModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 95% !important;background-color: #BCB6B61A !important;">
    <!-- Modal content-->
    <div class="modal-content" style="background-color: #0F0101E6 !important;">
    <div class="modal-header" style="border-bottom: 2px solid #0c0c0c;">
        <button type="button" class="close" data-dismiss="modal" style="color:white;font-size: 40px;">&times;</button>
    </div>    	
    <div class="modal-body" style="padding: 0px;">
      	<div style="width: 100%;overflow: auto;">
      	<?php
            $data['email_content'] = '';
            $data['email_template'] = 'email/newsletter';
            $this->load->view('templates/email/main', $data);
      	?>
      	</div>
      </div>
    </div>
  </div>
</div>
<!-- Email Preview Model-->

<script type="text/javascript">
	function showEmailTemplatePreview() {
		var email_content = $("#inputContent").val();
		$("#email_content_for_modal").html(email_content);

		$("#newsPreviewModal").modal('show');
	}
</script>

<?php
$this->load->view('templates/footers/admin_footer');
?>
<script src="<?php echo base_url(); ?>js/summernote.min.js"></script>
<script src="<?php echo base_url(); ?>js/pages/admin_add_custom_page.js"></script>