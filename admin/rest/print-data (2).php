<div class="card-body">
    <h4 class="card-title" style="text-align: center;"> Monitor Students Online</h4>
    <button onclick="printTable()" class="btn btn-primary mb-3">Print</button>
    
    <div class="table-responsive border rounded p-1">
        <!-- Search Bar -->
        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for Students ID, Student Class, Student Name, Last Seen" class="form-control mb-3">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th class="font-weight-bold">No</th>
                    <th class="font-weight-bold">Student ID</th>
                    <th class="font-weight-bold">Student Class</th>
                    <th class="font-weight-bold">Student Name</th>
                    <th class="font-weight-bold">Student Email</th>
                    <th class="font-weight-bold">Last Seen</th>
                    <th class="font-weight-bold">Active</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Your existing PHP code for displaying the student data
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function printTable() {
        var printContent = document.getElementById('table').outerHTML; // Get the table's HTML
        var win = window.open('', '', 'height=700,width=900'); // Open a new window
        win.document.write('<html><head><title>Print Table</title>');
        win.document.write('</head><body>');
        win.document.write(printContent); // Write the table HTML to the new window
        win.document.write('</body></html>');
        win.document.close(); // Close the document
        win.print(); // Trigger the print dialog
    }
</script>
