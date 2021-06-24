
<!-- START Online Users -->	
<div id="feedback">
  <div class="open_chat"><i class="fa fa-comments" aria-hidden="true"></i></div>
	<div id="feedback-form" class="col-xs-12 col-md-12 panel panel-default">		
	    <div id="feedback-tab"><span><?php echo $this->lang->line('chat_with_sugarbabe'); ?></span>
	       <div class="close_chat">X</div>
	    </div>
      <div class="side-one">
          <div class="row heading">
              <div class="col-md-12 col-sm-12 col-xs-12 heading-avatar">
              <h4 class="online_h4"> <?php echo $this->lang->line('there_are'); ?> <span class="online_user"><span id="online_user_count">0</span> <?php echo $this->lang->line('user_online'); ?></span> | <span class="new_user"><span id="new_user_count">0</span> <?php echo $this->lang->line('new_user'); ?></span></h4>
            </div>
          </div>		
          <!-- <div class="row sideBar content mCustomScrollbar"> -->
          <div class="row sideBar content" id="onlineUsersList">
          </div>		    
          <div class="row searchBox">
              <div class="col-sm-12 searchBox-inner">
                <div class="form-group has-feedback">
                  <input type="text" class="form-control" id="onlineUserSerachText" name="onlineUserSerachText" placeholder="<?php echo $this->lang->line('search_a_user_now'); ?>">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div>
          </div>
      </div>
	</div>	
</div>
<!-- End Online Users -->