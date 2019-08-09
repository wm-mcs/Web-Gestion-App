        <div class="post-preview">
          <a href=" {{$Noticia->route}}">
            <h2 class="post-title">
              {{$Noticia->name}} 
            </h2>
            <h3 class="post-subtitle">
                {{$Noticia->sub_name}} 
            </h3>
          </a>
          <p class="post-meta">Publicado por
            <a href="#">{{$Empresa->name}}</a> el
             {{$Noticia->created_at->format('d,m,y')}} 
          </p>
        </div>
        <hr class="post-hr">