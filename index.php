<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel mahasiswa</title>

     <!-- bootstrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

     <!-- datatables -->
     <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

</head>
<body>

<div class="mx-4 mt-3">
        <div class="card">
            <div class="border border-danger border-2 rounded"></div>
                <div class="card-body">
                    <table id="mahasiswa" class="table table-bordered table-hover table-striped mt-1" style="width:100%">
                        <thead>
                            <tr class="table-secondary">
                                <th>Nama </th>
                                <th>Alamat</th>
                                <th>Jurusan</th>
                                <th>Nilai IPK</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                    </table>
                </div>
        </div>
        <div class="card mt-3" style="margin-bottom: 20vh">
            <span class="border-danger border-top border-5 rounded-top"></span>
            <div class="card-body row">
                <div id="column-chart" class="col-md-4"></div>
                <div id="pie-chart" class="col-md-4"></div>
            </div>
        </div>
</div> 
        <div class="p-3"></div>

    <!-- jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<!-- datatables -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>



<!-- Highcharts -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.1.0/highcharts.js" integrity="sha512-8mNMOCKB2dbqlbvEAC4C4aMIioDavSLzEHF4P/A+V8ODWoaRnBz4zar7CGM8o1teyAV1sI7n6NhMLfgNZThWIA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/highchartTable/2.0.0/jquery.highchartTable.js" integrity="sha512-M44fzd5FnL3IRpBTFRQ+jzu2Cq8UA7HinHdMDHaoYt3+eNZNWuWGJe6v5BoNlnVLpqsKNb3CM2czqIkZhVebng==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>
 <script src="https://code.highcharts.com/modules/accessibility.js"></script>


 <script>
    $(document).ready(function () {
    
        const dTable = $('#mahasiswa').DataTable( {
     "ajax": {url: "http://localhost/mahasiswa/phprestapi.php?function=get_mahasiswa",
            dataSrc: "data",
        },
     "scrollX": true,
     "columns" : [
     {"data" : "nama"},
     {"data" : "alamat"},
     {"data" : "jurusan"},
     {"data" : "nilai_ipk"},
     {"data" : "grade"}
                ],
        });


        const tableData=getTableData(dTable);
        chart(tableData);
        setTableEvents(dTable);

    });


    function getTableData(table) {
    const dataArray = [],
        nama = [],
        nilai = [],
        grade = [];

    table.rows({ search: "applied" }).every(function () {
        const data = this.data();
        nama.push(data["nama"]);
        nilai.push(parseFloat(data["nilai_ipk"]));
        grade.push(data["grade"]);
    });

    dataArray.push(
        nama,
        nilai,
        grade
    );
    return dataArray;
}

function chart(data) {
    Highcharts.chart("column-chart", {
        chart: {
            type: "column",
        },
        title: {
            text: "Jumlah nilai",
        },
        xAxis: {
            categories: data[0],
            title: {
                text: null,
            },
        },
        yAxis: {
            title: {
                text: "Nilai",
            },
            labels: {
                overflow: "justify",
            },
        },
        series: [
            {
                name: "Nama",
                data: data[1],
            },
        ],
    });

    Highcharts.chart("pie-chart", {
        chart: {
            type: 'pie'
        },
        title: {
            text: "Grade nilai IPK",
        },
        series: [
            {
                name: "Jumlah",
                colorByPoint: true,
                data: [
                    {
                        name: 'Memuaskan',
                        y: data[1].filter((x) => x >= 2.0 && x <= 2.75).length,
                    },
                    {
                        name: 'Sangat Memuaskan',
                        y: data[1].filter((x) => x >= 2.76 && x <= 3.5).length,
                    },
                    {
                        name: 'Cum Laude',
                        y: data[1].filter((x) => x >= 3.51 && x <= 4.0).length,
                    }
                ]
            }
        ]
    })
}


    let draw = false;
    function setTableEvents(dTable){
        dTable.on("page", ()=>{
            draw=true;
        });
        dTable.on("draw", ()=>{
            if(draw){
                draw = false;
            } else {
                const tableData = getTableData(dTable);
                chart(tableData);

            }
        });
    }
</script>
</body>
</html>


