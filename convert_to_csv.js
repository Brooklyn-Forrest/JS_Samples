function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}


function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.getElementsByTagName("tr");

    for(let ele of rows){
        if(ele.id === "headers"){
            var row = [];
            cols = ele.getElementsByTagName('th');
            for (var y = 0; y < cols.length; y++) {
                if (cols[y].hasAttribute('hidden')) {

                } else {
                    data = cols[y].innerText;
                    row.push(data);
                }
            }
            csv.push(row.join(","));
        }
        else {
            row = [];
            cols = ele.getElementsByTagName('input');
            for (var j = 0; j < cols.length; j++) {
                if(cols[j].hasAttribute('hidden')){

                }
                else {
                    data = cols[j].value;
                    row.push(data);
                }
            }

            csv.push(row.join(","));
        }
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}