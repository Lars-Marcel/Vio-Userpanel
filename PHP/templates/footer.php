				</div>
				<!-- /. PAGE INNER  -->
				<a href="<?=IMPRINT_LINK?>" target="_blank" style="font-size:11px;">Impressum</a> <span style="float:right;">© <a href="https://www.mta-sa.org/user/2368-lars-marcel/" target="_blank">Lars-Marcel</a></span>
			</div>
			<!-- /. PAGE WRAPPER  -->
			
		</div>
		<!-- /. WRAPPER  -->
		
		<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
		<!-- BOOTSTRAP SCRIPTS -->
		<script src="assets/js/bootstrap.min.js"></script>
		<!-- METISMENU SCRIPTS -->
		<script src="assets/js/jquery.metisMenu.js"></script>
		<!-- DATA TABLE SCRIPTS -->
		<script src="assets/js/dataTables/jquery.dataTables.js"></script>
		<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>		
		<!-- CUSTOM SCRIPTS -->
		<script>
			function displayMap(x, y) {
				$("#map").attr("src", "ajax/map.php?x="+ x +"&y="+ y);
			}
			$(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
		</script>
		<script src="assets/js/custom.js"></script>
	</body>
</html>