@extends('templates.index')
@section('conteudo')
    <div class="container">
        <!--- MENSAGEM DE CONFIRMAÇÂO DE SUCESSO --->
        @if (session('msg'))
            <div class="alert alert-success" role="alert">
                {{ session('msg') }}
            </div>
        @endif
        <!--- FIM MENSAGEM DE CONFIRMAÇÂO DE SUCESSO --->

        <div class="container">
            <div class="row">
                <!-- BEGIN SEARCH RESULT -->
                <div class="col-md-12">
                    <div class="grid search">
                        <div class="grid-body">
                            <div class="row">
                                <!-- BEGIN FILTERS -->
                                <div class="col-md-3">
                                    <h2 class="grid-title"><i class="fa fa-filter"></i> Filtros</h2>
                                    <hr>
                                    <form action="{{ route('smartenvios.index') }}" method="get">
                                    <!-- BEGIN FILTER BY CATEGORY -->
                                    <h4>Status NF:</h4>
                                    <div class="checkbox">
                                        <label><input type="checkbox" class="icheck" value="1" name="filter"> Enviada</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" class="icheck" value="0" name="filter"> Pendênte</label>
                                    </div>
                                    <!-- END FILTER BY CATEGORY -->

                                    <div class="padding"></div>
                                    <!-- END FILTER BY DATE -->

                                    <div class="padding"></div>
                                </div>
                                <!-- END FILTERS -->
                                <!-- BEGIN RESULT -->
                                <div class="col-md-9">
                                    <h2> Pedidos <img src="https://smartenvios.com/wp-content/uploads/2023/01/536x156.png" width="200px" class="float-right"></h2>
                                    <hr>
                                    <!-- BEGIN SEARCH INPUT -->


                                        <div class="input-group">

                                            <input type="text" name="orderid" class="form-control"
                                                placeholder="Nº Pedido">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="fa fa-search"></i></button>
                                            </span>

                                        </div>
                                    </form>
                                    <!-- END SEARCH INPUT -->

                                    <div class="padding mt-3"></div>
                                    <!-- BEGIN TABLE RESULT -->
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <tbody>
                                                @foreach ($data as $pedido)
                                                    <tr>
                                                        <td class="number text-center">{{ $pedido->Orderid }}</td>
                                                        <td class="image"><img
                                                                src="https://www.bootdey.com/image/400x300/5F9EA0"
                                                                alt=""></td>
                                                        <td class="product">
                                                            <strong>Data Pedido: {{ $pedido->dataPedido }}</strong><br>{{ $pedido->nomeCliente }}
                                                        </td>

                                                        <td class="price text-right">R${{ $pedido->total }}</td>
                                                        @if ($pedido->NFenviada)
                                                            <td><a
                                                                    href="{{ route('smartenvios.show', ['id' => $pedido->id]) }}"><button
                                                                        class="btn btn-success"><i
                                                                            class="bi bi-filetype-xml"></i></button></a>
                                                            </td>
                                                        @else
                                                            <td><a
                                                                    href="{{ route('smartenvios.show', ['id' => $pedido->id]) }}"><button
                                                                        class="btn btn-warning"><i
                                                                            class="bi bi-filetype-xml"></i></button></a>
                                                            </td>
                                                        @endif
                                                        </a>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- END TABLE RESULT -->

                                    <!-- BEGIN PAGINATION -->
                                    <div class="d-flex">
                                        {!! $data->links() !!}
                                    </div>
                                    <!-- END PAGINATION -->
                                </div>
                                <!-- END RESULT -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END SEARCH RESULT -->
            </div>
        </div>
    @endsection
