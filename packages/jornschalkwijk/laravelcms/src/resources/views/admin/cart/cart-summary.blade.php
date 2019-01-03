<table class="table table-sm table-striped">
    <tr><th class="align-middle" colspan="4">Quantity</th><td class="align-middle" colspan="4">{{$cart->totalQuantity()}}</td></tr>
    <tr><th class="align-middle" colspan="4">Tax</th><td class="align-middle" colspan="4">€ {{$cart->totalTax}}</td>
    <tr><th class="align-middle" colspan="4">Shipping</th><td class="align-middle" colspan="4">€ {{$cart->shipping}}</td>
    <tr><th class="align-middle alert-success" colspan="4">Total</th><td colspan="4" class="align-middle alert-success">€ {{$cart->total()}}</td></tr>
</table>