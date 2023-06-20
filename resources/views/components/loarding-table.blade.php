<div class="main-item">
    <table class="table tbl-loarding">
      <tbody>
      </tbody>
    </table>
  <span hidden id="column">{{$column}}</span>
  <span hidden id="rol">{{$rol}}</span>
<script>
  $(function() {
    let column = parseInt($("#column").text());
    let rol = parseInt($("#rol").text());
    if (column > 0) {
      var tr = "";
      for (let i = 0; i < rol; i++) {
        var td = "";
        for (let index = 0; index < column; index++) {
          td +='<td>'+
                '<div class="animated-background">'+
                  '<div class="background-masker btn-divide-left"></div>'+
                '</div>'+
            '</td>';
        };
        tr +='<tr>'+(td)+"<tr>";
      }
      $(".tbl-loarding tbody").html(tr);
    }
  });
    
</script>