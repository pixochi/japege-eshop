<footer>
        <a href="<?= base_url(); ?>" target="_blank">Public Site</a>
         <p>Copyright <?= strftime("%Y",time()); ?> Japege team</p>
    </footer>
    </div>
  
</body>
<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js " integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa " crossorigin="anonymous "></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js
" type="text/javascript">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script type="text/javascript">
$(function(){
     $('.list_table').DataTable({
        responsive: true
    });
});
</script>
