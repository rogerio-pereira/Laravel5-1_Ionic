<h1>Olá {{$nome}} </h1>

<ul>
    @foreach ($linguagens as $linguagem)
        <li>{{$linguagem}}</li>
    @endforeach
</ul>