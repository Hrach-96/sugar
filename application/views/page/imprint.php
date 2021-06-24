<?php
$this->load->view('templates/headers/main_header', $title);
?>
<style type="text/css">
	table td {
		text-transform: none;
	}
</style>
<section class="breacrum_section common_back blckBack">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="breacrum">
					<h6 class="brdcrm_txt">
						<a class="bck_btn" href="<?php echo base_url('home'); ?>"><i class="flaticon-arrowhead-thin-outline-to-the-left"></i><?php echo $this->lang->line('back_to_home_page'); ?></a>
					</h6>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="question_section unlocks qstBox blckBack TermsBx">		
	<div class="container">
		<div class="row chat_bx">   
			<div class="col-md-12 QstnCol">
				<div class="tab question_bx" role="tabpanel">
					<div class="question_bx" id="Widerrufsrecht">
						<div class="row">	
							<div>								
								<div id="termsBx">
									<div class="row">
										<div class="col-md-12">
                                        <?php
                                        	echo '<img style="width:100%;" src="'.base_url('images/pages/imprint_'.$site_language).'.png" alt="....">';
                                        ?>
										</div>
									</div>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div>
</section>
<?php
$this->load->view('templates/footers/main_footer');
?>
