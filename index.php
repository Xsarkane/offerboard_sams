<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Samsung DASHBOARD</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="vendor/jquery-ui-1.12.1.custom/jquery-ui.min.css">
    <link rel="stylesheet" href="vendor/jquery-ui-1.12.1.custom/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="dist/css/bootstrap.css">
    <script src="vendor/jquery-ui-1.12.1.custom/external/jquery/jquery.js"></script>
    <script src="vendor/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <!--    <script type="text/javascript" src="/scripts/retina.js"></script>-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- https://github.com/SheetJS/js-xlsx-->
    <script src="vendor/js-xlsx-master/jszip.js"></script>
    <script src="vendor/js-xlsx-master/xlsx.js"></script>

    <!--POP_UPs-->
    <!-- Used for choosing the color for div Truck -->
    <link rel="stylesheet" href="vendor/PopUpMenu/popUp.css">
    <script src="vendor/PopUpMenu/popUp.js"></script>

</head>
<?php
require_once "php/con_db.php";
?>
<body>

<nav class="navbar navbar-dark logo">
    <a class="navbar-brand">
        <img src="img/logo-ss-sds.png" width="300" height="200" alt="Logo_Samsung_SDS">
    </a>
    <h2 class="title">DASHBOARD</h2>
    <div id="fileDropReceiver">
        <span>Перетащите сюда xlsx файл...</span>
    </div>
</nav>
<div class="row justify-content-center">
    <h2 id="cd"></h2>
</div>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="totalTable">
            <table id="totalTable">
                <tr>
                    <td class="totalTableHead"><span class="tableBold">Total Trucks</span></td>
                    <td class="totalTableHead"><span class="tableBold">Released Trucks</span></td>
                    <td class="totalTableHead"><span class="tableBold">Total Volume</span></td>
                    <td class="totalTableHead"><span class="tableBold">Moscow Trucks</span></td>
                    <td class="totalTableHead"><span class="tableBold">Moscow Volume</span></td>
                    <td class="totalTableHead"><span class="tableBold">Region Trucks</span></td>
                    <td class="totalTableHead"><span class="tableBold">Region Volume</span></td>
                    <td class="totalTableHead"><span class="tableBold">Pickup Trucks</span></td>
                    <td class="totalTableHead"><span class="tableBold">Pickup Volume</span></td>
                    <td class="totalTableHead"><span class="tableBold">Picking Finished</span></td>
                    <td class="totalTableHead"><span class="tableBold">Picking Delay</span></td>
                </tr>
                <?php
                $rows = mysqli_num_rows($result);
                $row = mysqli_fetch_row($result);
                for ($i = 1; $i < $rows; ++$i) {
                    $row = mysqli_fetch_row($result);
                    echo "<tr>";
                    echo
                    "<td class=\"totalTableData\" id=\"totalT\"><span class='TT'>$row[0]</span></td>
                    <td class=\"totalTableData\" id=\"releaseT\"><span class='RT'>$row[1]</span></td>
                    <td class=\"totalTableData\" id=\"totalV\"><span class='TV'>$row[2]</span></td>
                    <td class=\"totalTableData\" id=\"moscowT\"><span class='MT'>$row[3]</span></td>
                    <td class=\"totalTableData\" id=\"moscowV\"><span class='MV'>$row[4]</span></td>
                    <td class=\"totalTableData\" id=\"regionT\"><span class='RT'>$row[5]</span></td>
                    <td class=\"totalTableData\" id=\"regionV\"><span class='RV'>$row[6]</span></td>
                    <td class=\"totalTableData\" id=\"pickupT\"><span class='PT'>$row[7]</span></td>
                    <td class=\"totalTableData\" id=\"pickupV\"><span class='PV'>$row[8]</span></td>
                    <td class=\"totalTableData\" id=\"pickingS\"></td>
                    <td class=\"totalTableData\" id=\"pickingD\"></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</div>
<table> <?php
    $rows = mysqli_num_rows($result2);
    for ($i = 1; $i < $rows; ++$i) {
        $row = mysqli_fetch_row($result2);
        for ($j = 0; $j < 8; ++$j)
            echo "<td><div id='Truck_' class='Truck'>
                <p class='manifest'>$row[2]</p>
                <p class='DO'> DO: $row[1]</p>
                <p class='division'>$row[7]</p>
                <p class='client'>$row[3]</p>
                <p class='volume'>$row[4]</p>
                <div class='lastRow'>
                <p class='time'>$row[5]</p>
                <p class='date'>$row[6]</p>
                </div> 
                </div>
               </td>";
    }
    ?></table>
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="timeTable">
            <table id="timeTable">
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table id="yardTable">
        </table>
    </div>
</div>
<div class="yardTable">
</div>
<script>
    let TruckDate = new Date((date - 25569) * 24 * 60 * 60 * 1000 + time * 24 * 60 * 60 * 1000 - 3 * 60 * 60 * 1000);
    let TruckHour = TruckDate.getHours();
    let div = document.createElement("div");
    let currentTime = new Date().getHours();
    div.id = "Truck_" + ID;
</script>
<script>
    jQuery(() => {
        // There's the gallery and the trash
        let $gallery = $(".Truck"),
            $trash = $(".yardTableData");
        let $blink;
        $blink = $(".Truck_waiting");

        // Let the gallery items be draggable
        $gallery.draggable({
            cancel: "a.ui-icon", // clicking an icon won't initiate dragging
            revert: "invalid", // when not dropped, the item will revert back to its initial position
            //containment: "document",
            helper: "clone",
            cursor: "move",
            cursorAt: {top: 48, left: 55},
            opacity: 0.35,
            //iframeFix: true
        });

        // Let the trash be droppable, accepting the gallery items
        $trash.droppable({
            accept: ".Truck",
            classes: {
                "ui-droppable-active": "ui-state-highlight"
            },
            drop: function (event, ui) {
                drugTruck(ui.draggable, event.target);
            }
        });

        $blink.droppable({
            accept: ".Truck",
            classes: {
                "ui-droppable-active": "ui-state-highlight"
            },
            drop: function (event, ui) {
                drugTruck(ui.draggable, event.target);
            }
        });

        // Truck drug function
        function drugTruck($item, target) {
            $item.append().appendTo(target).fadeIn(function () {
                while (target.id === "GI") ;
            });

            $item.find("a.ui-icon-trash").remove();
            // console.log(target.id);
        }
    });
</script>
<button class="pal_btn">Добавить палет</button>
<!--  Прописываем макет всплывающего меню -->
<nav id="context-menu" class="context-menu">
    <ul class="context-menu__items">
        <li class="context-menu__item">
            <a href="#" class="context-menu__link" data-action="Moscow">МОСКВА (голубой)</a>
        </li>
        <li class="context-menu__item">
            <a href="#" class="context-menu__link" data-action="Regions">РЕГИОНЫ (темно-зеленый)</a>
        </li>
        <li class="context-menu__item">
            <a href="#" class="context-menu__link" data-action="Pickup">САМОВЫВОЗ (желтый)</a>
        </li>
        <li class="context-menu__item">
            <a href="#" class="context-menu__link" data-action="Label">Пометка о приезде</a>
        </li>
        <li class="context-menu__item">
            <a href="#" class="context-menu__link" data-action="Delay">Машина опаздывает</a>
        </li>
        <li class="context-menu__item">
            <a href="#" class="context-menu__link" data-action="Gate">Указать предварительный номер ворот и
                кладовщика</a>
        </li>
    </ul>
</nav>
<script src="main.js"></script>
<script>
    redrawTimeTable();
    redrawYardTable();
</script>
<div class="modal" tabindex="-1" role="dialog" id="modal1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Заполните поля</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Укажите предварительный номер ворот:</span>
                <input type="text" id="gate">
                <span>Укажите кладовщика:</span>
                <input type="text" id="storekeeper">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="apply" data-dismiss="modal" onClick="">Сохранить
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modal2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Заполните поля</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Укажите кол-во загружаемых машин:</span>
                <input type="text" id="ps">
                <span>Укажите количество опоздавших машин:</span>
                <input type="text" id="pd">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="remove">Очистить</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Сохранить</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modal3">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Создать палет</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Порядковый номер:</span>
                <input type="text" id="num">
                <span>Manifest:</span>
                <input type="text" id="man">
                <span>DO:</span>
                <input type="text" id="do">
                <span>Division:</span>
                <input type="text" id="div">
                <span>Client:</span>
                <input type="text" id="clt">
                <span>Volume:</span>
                <input type="text" id="vol">
                <span>Time:</span>
                <input type="text" id="time">
                <span>Date:</span>
                <input type="text" id="date">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Очистить</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="save">Сохранить</button>
            </div>
        </div>
    </div>
</div>
<script>truck_input();</script>
<script>
    setInterval(function () {
        $(".Truck_waiting").has('.Truck').addClass("blinking").animate({opacity: '0.0'}, 800);
        setTimeout(function () {
            $(".Truck_waiting").has('.Truck').addClass("blinking").animate({opacity: '1.0'}, 800);
        })
    });
</script>
<script>
    // $("#GI").has('#Truck').addClass("done").css({"backgroundColor": "#4D4848"});
</script>
<script>
    $('td#Pick_Start58').has('.Truck').css({"backgroundColor": "#4d0001"});
</script>
<script>remove_m2();</script>
<script>
    const X = XLSX;
    let XW = {
        /* worker message */
        msg: 'xlsx',
        /* worker scripts */
        worker: './xlsxworker.js'
    };

    let global_wb;

    const process_wb = (function () {
        let OUT;
        let HTMLOUT = document.getElementById('htmlout');

        const get_format = (function () {
            let radios = document.getElementsByName("format");
            return function () {
                for (let i = 0; i < radios.length; ++i) if (radios[i].checked || radios.length === 1) return radios[i].value;
            };
        })();

        const to_json = function to_json(workbook) {
            let result = {};
            workbook.SheetNames.forEach(function (sheetName) {
                let roa = X.utils.sheet_to_json(workbook.Sheets[sheetName], {header: 1});
                if (roa.length) result[sheetName] = roa;
            });
            return JSON.stringify(result, 2, 2);
        };

        const to_html = function to_html(workbook) {
            HTMLOUT.innerHTML = "";
            workbook.SheetNames.forEach(function (sheetName) {
                let htmlstr = X.write(workbook, {sheet: sheetName, type: 'string', bookType: 'html'});
                HTMLOUT.innerHTML += htmlstr;
            });
            return "";
        };

        return function process_wb(wb) {
            global_wb = wb;
            let output = "";
            // switch(get_format()) {
            if ("json" === "html") {
                output = to_html(wb);
            } else {
                output = to_json(wb);
            }
            // if(OUT.innerText === undefined) OUT.textContent = output;
            // else OUT.innerText = output;
            OUT = JSON.parse(output);
            document.getElementById("fileDropReceiver").hidden = true;
            // ОБРАБОТЧИК ОБЪЕКТА JSON - под создание объектов truck
            // console.log(OUT["данные"]);
            OUT["данные"].forEach(
                function (item) {
                    if ((item[0] != null) && (item.length > 1)) {
                        // console.log(item);
                        // ВЫВОД объекта div truck поля в таблице образца
                        addTruck(item[0], item[7], item[1], item[2], item[3], item[4], item[5], item[6],
                            item[8], item[9], item[10], item[11], item[12], item[13], item[14], item[15], item[16], item[17]);
                    }
                });
            if (typeof console !== 'undefined') console.log("Попытка обработки файла ", new Date());
        };
    })();

    const do_file = (function () {
        let rABS = typeof FileReader !== "undefined" && (FileReader.prototype || {}).readAsBinaryString;
        let domrabs = document.getElementsByName("userabs")[0];
        if (!rABS) domrabs.disabled = !(domrabs.checked = false);

        let use_worker = typeof Worker !== 'undefined';
        const domwork = document.getElementsByName("useworker")[0];
        if (!use_worker) domwork.disabled = !(domwork.checked = false);

        const xw = function xw(data, cb) {
            let worker = new Worker(XW.worker);
            worker.onmessage = function (e) {
                switch (e.data.t) {
                    case 'ready':
                        break;
                    case 'e':
                        console.error(e.data.d);
                        break;
                    case XW.msg:
                        cb(JSON.parse(e.data.d));
                        break;
                }
            };
            worker.postMessage({d: data, b: rABS ? 'binary' : 'array'});
        };

        return function do_file(files) {
            // console.log(files);
            // rABS = domrabs.checked;
            rABS = false;
            // use_worker = domwork.checked;
            use_worker = false;
            let f = files[0];
            let reader = new FileReader();
            reader.onload = function (e) {
                if (typeof console !== 'undefined') console.log("Попытка загрузки файла", new Date(), rABS, use_worker);
                let data = e.target.result;
                if (!rABS) data = new Uint8Array(data);
                if (use_worker) xw(data, process_wb);
                else process_wb(X.read(data, {type: rABS ? 'binary' : 'array'}));
            };
            if (rABS) reader.readAsBinaryString(f);
            else reader.readAsArrayBuffer(f);
        };
    })();

    (function () {
        const drop = document.getElementById('fileDropReceiver');
        if (!drop.addEventListener) return;

        function handleDrop(e) {
            e.stopPropagation();
            e.preventDefault();
            do_file(e.dataTransfer.files);
        }

        function handleDragover(e) {
            e.stopPropagation();
            e.preventDefault();
            e.dataTransfer.dropEffect = 'copy';
        }

        drop.addEventListener('dragenter', handleDragover, false);
        drop.addEventListener('dragover', handleDragover, false);
        drop.addEventListener('drop', handleDrop, false);

    })();

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36810333-1']);
    _gaq.push(['_trackPageview']);

    (function () {
        const ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' === document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        const s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();


    truckPopUpMenu();
</script>


</body>
</html>