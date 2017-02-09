        <div class="modal fade in" id="alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" id="congrats_header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Congratulations !</h4>
                    </div>
                    <div class="modal-body">
                       <div id="congrats">You are now the proud owner of : 
                        <ol>
                        <?php foreach($this->session->products_bought as $product) { ?> 
                       <li><?= $product->name; ?></li>
                       <?php } ?>
                       </ol>
                        starter packs ! </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Awesome !</button>
                        
                    </div>
                </div>
            </div>
        </div>
                 <script type="text/javascript">$(function(){$("#alert").modal();});</script>