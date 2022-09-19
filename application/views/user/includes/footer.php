</div>
            <!-- /#page-content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- Bootstrap Core JavaScript -->        
        <script src="<?php echo site_url('private/js/bootstrap.min.js'); ?>"></script>     
        <!-- All plugins -->
        <script src="<?php echo site_url('private/plugins/bootstrap-fileinput-master/js/fileinput.min.js') ;?>"></script>
        <script src="<?php echo site_url('private/plugins/peity/jquery.peity.min.js')?>"></script>
        
    	<!-- Nice Scroll -->
    	<script src="<?php echo site_url('private/js/jquery.nicescroll.min.js'); ?>"></script>
	
        <!-- custom Core JavaScript -->
        <script src="<?php echo site_url('private/js/script.js'); ?>"></script>
 

        <!-- Menu Toggle Script -->
        <script>
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
                $(this).toggleClass("icon-change");
                $(".sidebar-brand").toggleClass("sidebar-slide");
            });
            
            $('#datetimepicker1').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        
            // linking between two date
            $('#datetimepickerFrom').datetimepicker();
            $('#datetimepickerTo').datetimepicker({
                useCurrent: false
            });
            $("#datetimepickerFrom").on("dp.change", function (e) {
                $('#datetimepickerTo').data("DateTimePicker").minDate(e.date);
            });
            $("#datetimepickerTo").on("dp.change", function (e) {
                $('#datetimepickerFrom').data("DateTimePicker").maxDate(e.date);
            });

            // file upload with plugin options
            $("input#input").fileinput({
                browseLabel: "Pick Image",
                previewFileType: "text",
                allowedFileExtensions: ["jpg", "jpeg", "png"],
            });

            $("#formSubmit").submit(function () {
                $(this).find(":submit").css("pointer-events", "none").val('Submitted...');
            });
        </script>

    </body>
</html>