<div class='form-group'>
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', $statusList, null, ['class' => 'form-control']) !!}
</div>

<div class='form-group'>
    {!! Form::label('user_delivery_man_id', 'Entregador:') !!}
    {!! Form::select('user_delivery_man_id', $deliverymen, null, ['class' => 'form-control']) !!}
</div>