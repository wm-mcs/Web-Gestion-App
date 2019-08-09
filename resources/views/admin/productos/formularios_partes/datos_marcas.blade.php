<div class="formulario-label-fiel">
{!! Form::label('marca_asociado_id', 'Marcas', ['class' => 'control-label']) !!}

<select id="select-marcas" multiple  style="margin: 15px 0;" value="{{ Input::old('marca_asociado_id') }}" name="marca_asociado_id[]">
                   
      @foreach($Marcas as $Marca)
        <OPTION data-img-src=" {{$Marca->url_img}}" 
                      VALUE="{{$Marca->id}}"
                      >
        {{$Marca->name}} 
        </OPTION>
      @endforeach 
</select>
</div>