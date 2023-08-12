<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" contents="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <title>Document</title>
</head>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<body style="background-color: #f4f6f9">

<section class="content">
    <div class="container-fluid mt-5">
        <div id="headingDiv" class="row">
            <h1 id="contentHeading"> Profit Chart </h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div id="buttonsDiv" style="display: flex; justify-content: space-between;">
                    <div>
                    <button id="profitsButton" class="btn btn-outline-light" style="float:left; margin-bottom:10px; background-color: grey;" disabled="disabled"> Profit Graph </button>
                    <button id="incomesButton" class="btn btn-outline-light" style="float:left; margin-bottom:10px; background-color: grey;"> Incomes </button>
                    <button id="expensesButton" class="btn btn-outline-light" style="float:left; margin-bottom:10px; background-color: grey;"> Expenses </button>
                    </div>
                </div>
                <div style="display: flex; justify-content: center; align-items: center;">
                    <div id="profitChart" style="width: 1800px; height: 535px">
                    </div>
                </div>

                <table id="myTable">
                </table>
            </div>
        </div>
    </div>
</section>

        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">






                $(document).ready(function() {


                $.get("/api/profits", function(response) {
                    var chartArray = [];
                    var columnNames = ['Day', 'Income (daily)'];
                    var chartArray = [columnNames];

                    var last7Days = response.slice(-30);
                    last7Days.forEach((data)=> {

                        var date = new Date(data.date);
                                var options = { year: 'numeric', month: 'short', day: 'numeric' };
                                var convertedCreated_at = date.toLocaleDateString('en-US', options);

                                var amount = parseFloat(data.amount);

                                var dataRows = [
                                [convertedCreated_at, amount]
                                ];
                                dataRows.forEach(function(row) {
                                    chartArray.push(row);
                                });
                            });
                                drawChart(chartArray);
                }).fail(function(xhr, status, error) {
                            console.log(error);
                    });


                var buttonID_p = "#profitsButton";
                var buttonID_i = "#incomesButton";
                var buttonID_e = "#expensesButton";


                var callIncomesTable = false;
                var callExpensesTable = false;

                $(buttonID_p).click(function() {
                    location.reload();
                });

                $(buttonID_i).click(function() {
                    callIncomesTable = true;
                    checkButtonClicks(buttonID_i, buttonID_e, buttonID_p);
                });

                $(buttonID_e).click(function() {
                    callExpensesTable = true;
                    checkButtonClicks(buttonID_e, buttonID_i, buttonID_p);
                });


                //Checking button clicks and which one getting clicked
                function checkButtonClicks(disableID, enableID, profitsEnable) {
                    $(disableID).prop("disabled", true);
                    $(enableID).prop("disabled", false);
                    $(profitsEnable).prop("disabled", false);
                    $('#contentHeading').remove();

                    $('#profitChart').remove();

                    if ($.fn.DataTable.isDataTable('#myTable')) {
                        $('#myTable').DataTable().clear().draw();
                    }
                    else {
                        createTable();
                    }

                    if (callIncomesTable) {
                        callIncomesTable = false;
                        var incomesData = "/api/incomes";
                        iHeading = "<h1 id='contentHeading'> Incomes </h1>";
                        routeIn = "{{ route('incomes')}}";
                        fillTable(incomesData, iHeading, routeIn);
                    }
                    else if (callExpensesTable) {
                        callExpensesTable = false;
                        var expensesData = "/api/expenses";
                        eHeading = "<h1 id='contentHeading'> Expenses </h1>";
                        routeEx = "{{ route('expenses')}}";
                        fillTable(expensesData, eHeading, routeEx);
                    }
                }


                //Table and heading creation
                function createTable() {
                        $('#myTable').DataTable({
                            processing: true,
                            columns: 
                            [{ 
                                title: 'Date',
                            },

                            {
                                title: 'Description'
                            },


                            { 
                                title: 'Amount',
                            },

                            {
                                title: 'Category'
                            },

                            {
                                title: 'Account'
                            }
                            ],
                            "order": [[ 0, "desc" ]]
                        });
                };


                function fillTable(tablePick, heading, route) {
                        $('#headingDiv').append(heading);
                        if ($('#addButton')){;
                            $('#addButton').remove();
                        }
                        addButton = '<a id="addButton" href='+route+' class="btn btn-outline-success" style="margin-bottom:10px;"> Add </a>';
                        $('#buttonsDiv').append(addButton);
                        $.get(tablePick, function(response) {
                            response.forEach((data)=> {
                                var date = new Date(data.created_at);
                                var options = { year: 'numeric', month: 'short', day: 'numeric' };
                                var convertedCreated_at = date.toLocaleDateString('en-US', options);

                                var amount = data.amount;
                                var formattedAmount = amount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

                            $('#myTable').DataTable().row.add([
                                convertedCreated_at,
                                data.description,
                                formattedAmount,
                                data.category,
                                data.account
                            ] ).draw( false );
                            });

                        }).fail(function(xhr, status, error) {
                            console.log(error);
                        });
                };

                    google.charts.load('current', {'packages':['corechart']});
                    function drawChart(chartArray) {
                        var data = google.visualization.arrayToDataTable(chartArray);
                        var options = {
                        title: '(last 30 days)',
                        curveType: 'function',
                        legend: { position: 'bottom' }
                        };

                        var chart = new google.visualization.LineChart(document.getElementById('profitChart'));
                        chart.draw(data, options);
                    }

                });
                </script>
                </body>
                </html>