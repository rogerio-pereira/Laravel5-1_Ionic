@extends('app')

@section('content')
    <div class='container'>
        <h3>Novo Pedido</h3>
        
        @include('errors._check')

        {!! Form::open(/*['route' => 'customer.checkout.store']*/) !!}
            <div class='form-group'>
                <label>Total:</label>
                <p id='total'></p>
                <a href='#' id='btnNewItem' class='btn btn-default'>Novo Item</a>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select class='form-control' name='items[0][product_id'>
                                    @foreach ($products as $p)
                                        <option value='{{$p->id}}' data-price='{{$p->price}}'>
                                            {{$p->name}} - {{$p->price}}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                {!! Form::text('items[0][qtd]', 1, ['class' => 'form-control']) !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class='form-group'>
                {!! Form::submit('Criar Pedido', ['class' => 'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('post-scripts')
    <script>
        $('#btnNewItem').click(function(){
            var row = $('table tbody > tr:last'), 
                newRow = row.clone(),
                length = $('table tbody tr').length;

            newRow.find('td').each(function() {
                var td = $(this),
                    input = td.find('input,select'),
                    name = input.attr('name');

                input.attr('name', name.replace((length-1) + '', length + ''));
            });

            newRow.find('input').val(1);
            newRow.insertAfter(row);
        });
    </script>
@endsection