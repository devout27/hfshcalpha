<?php if($dataTableElement): ?>
    <script>
        $(document).ready(function()
        {        
            if($('#<?=$dataTableElement?>').length)
            {
                $('#<?=$dataTableElement?>').DataTable({
                    "processing": true,        
                    "serverSide": true,
                    "searching": true,
                    "paging": true,
                    "info": false,
                    "lengthMenu": [ 10, 25, 50,100 ],
                    "pageLength":10,        
                    "order": [],        
                    "ajax": {
                        "url": '<?=$dataTableURL?>',
                        "type": "POST"
                    },
                    "columns": [                        
                        null,
                        null,
                        null,
                        null,
                        { "width": "100px" },
                        null,
                        null,
                        null,                        
                    ],        
                    "columnDefs": [{ 
                        "targets": [0],
                        "orderable": true
                    }]
                });
            }
        })
    </script>
<?php endif; ?>