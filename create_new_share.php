<?php
include "header-nav.php";
?>
<script src="assist.js" type="text/javascript"></script>
<div style="background-color: white; display: inline-block; border: 2px solid black; padding-left: 20px; padding-bottom: 27px; padding-top: 5px; padding-right: 20px;">
    <h3 style="display: inline-block; margin-right: 200px;">Creating New Fileshare</h3>
    <button id="defaults" onclick="window.location.href='defaultconf.php'" class="basicstyle">Create/Edit Your Defaults</button>
    <button id="default-fill" onclick="clearx()" class="basicstyle">Clear Form</button>
    <br>
    <div style="display: inline-block">
        <p>Define parent location:</p>
        <form id="fileform" action="create-share.php" method="post">
            <label for="access-point" style="padding-right: 148px;">Access Point</label>
            <select id="access-point" name="access-point" style="width: 270px;">
                <?php
                //require "C:/Users/tpstor13/xampp/Requests-master/Requests-master/library/Requests.php";

                $_GET['request'] = 'getfileshares';
                $_GET['option'] = 'paths';
                require_once "isilon-api.php";

                // For ordering by server/access point
                // For ordering by server/access point
                $pattern_short = "(/ifs/wdc-isifs-01/[a-zA-Z0-9-]+)";
                $accesspoints = array();

                foreach($datavar as $path){
                    preg_match($pattern_short, $path, $accesspoint);
                    if (in_array($accesspoint[0], $accesspoints) === false){
                        array_push($accesspoints, $accesspoint[0]);
                    }
                }

                echo "<option disabled selected>--Required--</option>";

                foreach($accesspoints as $point){
                    echo "<option value=$point>$point</option>";
                }

                echo "</select></div><br><br>";
                echo "<label for='folderlevel1' style='padding-right: 20px;'>Share layers in this access point:</label>";
                echo "<select id='folderlevel1' name='folderlevel1' style='width: 220px;'>";
                echo "</select>";
                echo "<select id='folderlevel2' name='folderlevel2' style='width: 240px;'></select>";

                echo "<input hidden id='paths' value='".json_encode($datavar)."'>";
                echo "<br><br><br><b>New Fileshare Name:</b><br><br>";
                echo "<input type='text' style='width: 250px;' id='share-text' name='share-text' autocomplete='off' spellcheck='false' class='underlineonly'>"
                ?>
                <script>
                    function filtershares(){
                        val = document.getElementById('access-point').value;
                        obj = document.getElementById('folderlevel1');

                        $('#folderlevel1')
                            .empty()
                            .append('<option selected disabled>--Required--</option>');

                        $('#folderlevel2')
                            .empty();

                        var data = document.getElementById('paths').value;

                        newdata = data.replace(/"/g, '');
                        dataf = newdata.replace(/\\/g, '');
                        var dataarray = dataf.split(',');

                        if(dataarray[0].includes('[')) {
                            dataarray[0] = dataarray[0].replace('[', '');
                        }

                        primarylist = [];
                        filelist = [];
                        for(var i=0; i < dataarray.length; i++){
                            ref = dataarray[i];
                            newref = ref.replace(/ifs\/wdc-isifs-01\/[a-zA-Z0-9-]+/, '');
                            finalref = newref.replace(/\//, '');
                            if(ref.includes(val)){
                                if(ref.includes("/nfs")){
                                    regex = /\/[a-zA-z0-9-]+\/[a-zA-Z0-9]+\/[a-zA-Z0-9_]+/;
                                    layer = finalref.match(regex);
                                    if(primarylist.includes(layer[0])){
                                        filelist.push(finalref);
                                    }
                                    else{
                                        primarylist.push(layer[0]);
                                        filelist.push(finalref);
                                    }
                                }
                                else {
                                    regex = /\/[a-zA-z0-9-]+/;
                                    layer = finalref.match(regex);

                                    if (primarylist.includes(layer[0])) {
                                        filelist.push(finalref);
                                    } else {
                                        primarylist.push(layer[0]);
                                        filelist.push(finalref);
                                    }
                                }
                            }
                        }
                        for(var y = 0; y < primarylist.length; y++){
                            var option = document.createElement("option");
                            option.value = primarylist[y];
                            option.innerHTML = primarylist[y];

                            obj.appendChild(option);
                        }
                    }

                    function filterlayer(){


                        $('#folderlevel2')
                            .empty()
                            .append('<option selected>(None Selected)</option>');

                        second_obj = document.getElementById('folderlevel2');
                        selected = document.getElementById('folderlevel1').value;

                        if(filelist[filelist.length-1].includes(']')){
                            filelist[filelist.length-1].replace(']', '');
                        }

                        for(var y = 0; y < filelist.length; y++){
                            console.log(filelist[y]);
                            if(filelist[y].includes(selected)) {
                                layerdup = filelist[y].match(regex);
                                editedref = filelist[y].replace(layerdup[0], "");

                                var option = document.createElement("option");
                                option.value = editedref;
                                option.innerHTML = editedref;

                                second_obj.appendChild(option);
                            }
                        }
                        var options = $('#folderlevel2 option');
                        var arr = options.map(function(_, o) { return { t: $(o).text(), v: o.value }; }).get();

                        arr.sort(function(o1, o2){ return o1.t.toLowerCase() > o2.t.toLowerCase() ? 1 : o1.t.toLowerCase() < o2.t.toLowerCase() ? -1 : 0; });
                        options.each(function(i, o) {
                            o.value = arr[i].v;
                            $(o).text(arr[i].t);
                        });
                    }

                    document.getElementById('access-point').addEventListener('change', filtershares);
                    document.getElementById('folderlevel1').addEventListener('change', filterlayer);

                    function redirect(){
                        loading('', 'loadingdiv');
                        fileform.submit();
                    }
                </script>
                <br><br><br>
                <label for="email" style="font-weight: bold">Provide a Group Email*:</label><br><br>
                <input type="text" name="email" id="email" pattern="/.+@\..+/" style="width: 250px;" class="underlineonly" spellcheck="false">
                <br><br><br>
                <label for="paging" style="font-weight: bold">Provide a Paging Group Name:</label><br><br>
                <input type="text" name="paging" id="paging" style="width: 250px;" class="underlineonly" spellcheck="false">
                <br><br><br>
                <b>Create a Threshold Notification</b><br><br>
                <div style="display: inline-block; vertical-align: top; margin-right: 40px;">
                <label for="threshold">Type</label>
                <select id="threshold">
                    <option disabled selected>--Select--</option>
                    <option>Advisory</option>
                    <option>Soft Quota</option>
                </select>
                </div>
                <div style="display: inline-block; vertical-align: top;">
                <label for="threshold">Condition</label>
                <select id="threshold">
                    <option disabled selected>--Select--</option>
                    <option>Exceeded</option>
                    <option>Violated</option>
                </select>
                </div>
                <br><br>
                <p>Schedule for this Notification</p>
                <div style="display: inline-block; vertical-align: top; margin-right: 50px;">
                    <p>Who</p>
                <input type="checkbox" id="emailnotif" name="emailnotif">
                <label for="emailnotif">Group Email</label><br>
                <input type="checkbox" id="pagenotif" name="pagenotif">
                <label for="pagenotif">Page Group</label><br><br>
                </div>
                <div style="display: inline-block; vertical-align: top; margin-right: 50px">
                    <p>Frequency</p>
                <label for="days">Every x days:</label>
                <input type="number" id="days" name="days" style="width: 40px; margin-left: 6px;" min="1" max="100">
                <br>
                <label for="hours">Every x hours:</label>
                <input type="number" id="hours" name="hours" style="width: 40px;" min="1" max="24">
                <br><br>
                </div>
                <div style="display: inline-block; vertical-align: top;">
                    <p>When</p>
                    <label for="stime">Start time:</label>
                    <input type="time" id="stime" name="stime" style="margin-left: 6px;">
                    <br>
                    <label for="etime">End time:</label>
                    <input type="time" id="etime" name="etime" style="margin-left: 11px;">
                    <br><br>
                </div>
                <br><br><br>
                <b>Create a Hard Quota*</b>
                <br><br>
                <label for="threshold">Condition</label>
                <select id="threshold">
                    <option disabled selected>--Select--</option>
                    <option>Exceeded</option>
                    <option>Violated</option>
                </select>
                <br><br>
                <div class="button button-6" onclick="redirect()" style="width: 120px; height: 30px;">
                    <div id="spin"></div>
                    <a>Go</a>
                </div>
                <div id="loadingdiv" style="padding-left: 10px;"></div>
        </form>
    </div>