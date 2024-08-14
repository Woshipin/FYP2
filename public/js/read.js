function readExcelFile() {
    var fileInput = document.getElementById('excelFileInput');
    var file = fileInput.files[0];
  
    var reader = new FileReader();
  
    reader.onload = function(e) {
      var data = new Uint8Array(e.target.result);
      var workbook = XLSX.read(data, { type: 'array', cellDates: true, cellStyles: true, cellFormula: true, bookVBA: true });
      var worksheet = workbook.Sheets[workbook.SheetNames[0]];
  
      var excelData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
      var outputElement = document.getElementById('output');
      outputElement.innerHTML = '';
  
      for (var i = 0; i < excelData.length; i++) {
        var row = excelData[i];
  
        for (var j = 0; j < row.length; j++) {
          var cell = row[j];
          outputElement.innerHTML += cell + ' ';
        }
  
        outputElement.innerHTML += '<br>';
      }
    };
  
    reader.readAsArrayBuffer(file);
  }
  