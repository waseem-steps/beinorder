<script>
    function printDiv() {
    var divContents = document.getElementById("GFG").innerHTML;
    var a = window.open('', '', 'height=500, width=500');
    a.document.write(`<div class="x_panel" id='dt_name{{ $order->id }}'>`);
    a.document.close();
    a.print();
    }
</script>
