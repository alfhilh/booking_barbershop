<?php
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
    }


    // Making Timelots >> Part 3
    $duration = 90;
    $cleanup = 30;
    $start = "10:00";
    $end = '24:00';

    function timeslots($duration, $cleanup, $start, $end)
    {
        $start = new DateTime($start);
        $end = new DateTime($end);
        $interval = new DateInterval('PT' . $duration . 'M');
        $cleanupinterval = new DateInterval('PT' . $cleanup . 'M');
        $slots = array();

        for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupinterval)) {
            $endperiod = clone $intStart;
            $endperiod->add($interval);
            if ($endperiod > $end) {
                break;
            }
            $slots[] = $intStart->format('H:iA') . '-' . $endperiod->format('H:iA');
        }

        return $slots;
    }

    ?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <style>
            @media only screen and (max-width: 760px),
            (min-device-width: 802px) and (max-device-width: 1020px) {

                /* Force table to not be like tables anymore */
                table,
                thead,
                tbody,
                th,
                td,
                tr {
                    display: block;

                }

                .empty {
                    display: none;
                }

                /* Hide table headers (but not display: none;, for accessibility) */
                th {
                    position: absolute;
                    top: -9999px;
                    left: -9999px;
                }

                tr {
                    border: 1px solid #ccc;
                }

                td {
                    /* Behave  like a "row" */
                    border: none;
                    border-bottom: 1px solid #eee;
                    position: relative;
                    padding-left: 50%;
                }



                /*
    Label the data
    */
                td:nth-of-type(1):before {
                    content: "Sunday";
                }

                td:nth-of-type(2):before {
                    content: "Monday";
                }

                td:nth-of-type(3):before {
                    content: "Tuesday";
                }

                td:nth-of-type(4):before {
                    content: "Wednesday";
                }

                td:nth-of-type(5):before {
                    content: "Thursday";
                }

                td:nth-of-type(6):before {
                    content: "Friday";
                }

                td:nth-of-type(7):before {
                    content: "Saturday";
                }


            }

            /* Smartphones (portrait and landscape) ----------- */

            @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
                body {
                    padding: 0;
                    margin: 0;
                }
            }

            /* iPads (portrait and landscape) ----------- */

            @media only screen and (min-device-width: 802px) and (max-device-width: 1020px) {
                body {
                    width: 495px;
                }
            }

            @media (min-width:641px) {
                table {
                    table-layout: fixed;
                }

                td {
                    width: 33%;
                }
            }

            .row {
                margin-top: 20px;
            }

            .today {
                background: yellow;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h1 class="text-center">Book for Date: <?php echo date('m/d/Y', strtotime($date)); ?></h1>
            <hr>
            <div class="row">
                <!-- part 4 -->
                <div class="col-md-12">
                    <?php echo isset($msg) ? $msg : ''; ?>
                </div>
                <!-- Part 3 -->
                <?php
                $timesolts = timeslots($duration, $cleanup, $start, $end);
                foreach ($timesolts as $ts) {
                ?>
                    <div class="col-2">
                        <div class="form-group">
                            <button class="btn btn-success book" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Modal Part 4 -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Booking: <span id="slot"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="">Time Slot</label>
                                        <input required type="text" readonly name="timeslot" id="timeslot" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">services</label>
                                        <input required type="text" readonly name="service" id="service" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input required type="text" name="name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input required type="email" name="email" class="form-control">
                                    </div>
                                    <div class="form-group pull-right">
                                        <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
        <script>
            $(function() {
                'use strict';
                $('.book').click(function() {
                    var timeslot = $(this).attr('data-timeslot');
                    $('#slot').html(timeslot);
                    $('#timeslot').val(timeslot);
                    $('#myModal').modal('show');
                });
            });
        </script>
    </body>

    </html>