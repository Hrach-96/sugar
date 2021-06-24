<?php
$this->load->view('templates/headers/admin_header', $title);
?>
<style type="text/css">
	.pagination_ul li {
		display: inline-block;
	}
	.pagination_ul {
		padding:10px;
	}	
	.pagination_ul li .active {
		background: #140c0c1a;
	}
	.thumbnail img {
		height: 189px;
	}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2></h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript:void(0);"><?php echo $this->lang->line('admin'); ?></a>
            </li>
            <li>
                <a href="<?php echo base_url('admin/vouchers'); ?>"><?php echo $this->lang->line('vouchers'); ?></a>
            </li>
        </ol>
    </div>
</div>

<div class="col-lg-12 block_form">
	<?php if($this->session->flashdata('message')) { ?>
	<div class="alert alert-info">
		<?php echo $this->session->flashdata('message'); ?>
	</div>
	<?php } ?>
    <div class="ibox-content-no-bg">
    	<div class="row">
	    	<div class="col-lg-12">
	    		<div class="pull-right">
	    			<a href="<?php echo base_url('admin/vouchers/addVoucher'); ?>" class="btn btn-success" style="border-radius: 5px;padding: 4px 20px;"><?php echo $this->lang->line('add_voucher'); ?></a>
	    		</div>			
	    	</div>
    	</div>
		<div class="clearfix">
	    <?php 
	    	if(!empty($vouchers)):
	    ?>
			<table class="table table-striped table-hover">
				<thead>
					<th></th>
					<th><?php echo $this->lang->line('procent_voucher'); ?></th>
					<th><?php echo $this->lang->line('code_voucher'); ?></th>
					<th><?php echo $this->lang->line('edit'); ?></th>
					<th><?php echo $this->lang->line('delete'); ?></th>
				</thead>
				<tbody>
	    <?php
	    		$sr_no = $offset + 1;
	    		foreach($vouchers as $voucher):
			?>
			<tr>
				<td><?php echo $voucher['id']; ?></td>
				<td><?php echo $voucher['procent']; ?> %</td>
				<td><?php echo $voucher['code']; ?></td>
				<td><a href="<?php echo base_url('admin/vouchers/editVoucher/').$voucher['id']; ?>"><i class="fa fa-edit"></i> <?php echo $this->lang->line('edit'); ?></a></td>
				<td><a  class='text-danger' href="<?php echo base_url('admin/vouchers/removeVoucher/').$voucher['id']; ?>"><i class="fa fa-remove"></i> <?php echo $this->lang->line('delete'); ?></a></td>
			</tr>	    	
			<?php
				endforeach;
			?>
				</tbody>
			</table>

			<?php
				if($links != ""):
			?>
			<div class="col-sm-12">
				<div class="btnmoreplaceholder">
					<?php echo $links; ?>
				</div>
			</div>
			<?php
				endif; 
			?>			

			<?php
			else:
			?>
			<div class="alert alert-info">
				<?php echo $this->lang->line('no_one_found'); ?>					
			</div>
			<?php
			endif;
			?>
		</div>
    </div>
</div>
<?php
$this->load->view('templates/footers/admin_footer');
?>