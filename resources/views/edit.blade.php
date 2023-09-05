@extends('templates.index')
@section('conteudo')
    <div class="container">
        <div class="container py-5">

            <!-- For demo purpose -->
            <div class="row mb-4">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4">SmartEnvios Pedido: {{ $data->Orderid }}</h1>
                </div>
            </div>
            <!-- End -->

            <!--- MENSAGEM DE CONFIRMAÇÂO DE SUCESSO --->
            @if (session('msg'))
                <div class="alert alert-success" role="alert">
                    {{ session('msg') }}
                </div>
            @endif
            <!--- FIM MENSAGEM DE CONFIRMAÇÂO DE SUCESSO --->

            <!--- MENSAGEM DE CONFIRMAÇÂO DE SUCESSO --->
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    @if(!is_array(session('error')))
                    <li>{{session('error')}}</li>
                    @else
                    @foreach (session('error') as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                    @endif
                </div>
            @endif
            <!--- FIM MENSAGEM DE CONFIRMAÇÂO DE SUCESSO --->

            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="bg-white rounded-lg shadow-sm p-5">
                        <!-- Credit card form tabs -->
                        <ul role="tablist" class="nav bg-light nav-pills rounded-pill nav-fill mb-3">
                            <li class="nav-item">
                                <a data-toggle="pill" href="#nav-tab-card" class="nav-link active rounded-pill">
                                    <i class="fa fa-credit-card"></i>
                                    Dados Cliente
                                </a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="pill" href="#nav-tab-paypal" class="nav-link rounded-pill">
                                    <i class="bi bi-filetype-xml"></i>
                                    Envio XML
                                </a>
                            </li>
                        </ul>
                        <!-- End -->


                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- credit card info-->
                            <div id="nav-tab-card" class="tab-pane fade show active">
                                <form role="form">
                                    <div class="form-group">
                                        <label for="username">Cliente Nome</label>
                                        <input type="text" name="username" value="{{ $data->nomeCliente }}" required
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="cardNumber">Email</label>
                                        <div class="input-group">
                                            <input type="text" name="cardNumber" value="{{ $data->email }}"
                                                class="form-control" required>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="validationCustom01" class="form-label">Documento</label>
                                            <input type="text" class="form-control" id="validationCustom01"
                                                value="{{ $data->documento }}" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="validationCustom01" class="form-label">Logradouro</label>
                                            <input type="text" class="form-control" id="validationCustom01"
                                                value="{{ $data->endereco }}" required>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="validationCustom02" class="form-label">N°: </label>
                                            <input type="text" class="form-control" id="validationCustom02"
                                                value="{{ $data->NumeroCasa }}" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="validationCustom01" class="form-label">Cep: </label>
                                            <input type="text" class="form-control" id="validationCustom01"
                                                value="{{ $data->cep }}" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="validationCustom01" class="form-label">Total R$:</label>
                                            <input type="text" class="form-control" id="validationCustom01"
                                                value="{{ $data->total }}" required>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="validationCustom01" class="form-label">Frete R$:</label>
                                            <input type="text" class="form-control" id="validationCustom01"
                                                value="{{ $data->shipment_value }}" required>
                                        </div>
                                        <div class="col-md-5 mt-3">
                                            <label for="validationCustom01" class="form-label">Código da Etiqueta </label>
                                            <input type="text" class="form-control" id="validationCustom01"
                                                value="{{ $data->freight_order_tracking_code }}" required>
                                        </div>
                                        <div class="col-md-2 mt-3">
                                            <label for="validationCustom01" class="form-label">Peso </label>
                                            <input type="text" class="form-control" id="validationCustom01"
                                                value="{{ $data->Peso }}" required>
                                        </div>
                                    </div>

                                    <div class="card mt-3">
                                        <div class="card-header bg-primary text-white">
                                            Produtos
                                        </div>
                                        <ul class="list-group list-group-flush ">
                                            @foreach (json_decode($data->produtosPainel) as $produto)
                                                @foreach ($produto->pictures as $picture)

                                                @endforeach
                                                <li class="list-group-item"><img src="{{$picture->http}}" alt="" srcset="" width="50px">{{ $produto->description }}</li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <button type="button"
                                        class="subscribe btn btn-primary btn-block rounded-pill shadow-sm mt-5"> Confirm
                                    </button>
                                </form>
                            </div>
                            <!-- End -->

                            <!-- Paypal info -->
                            <div id="nav-tab-paypal" class="tab-pane fade">
                                <p>Selecione a XML do Pedido: </p>

                                <form action="{{ route('uploadXml', ['id' => $data->Orderid]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3 mt-2">
                                        <label for="validationCustom01" class="form-label">freight_order_id</label>
                                        <input type="text" name="freight_order_id" class="form-control"
                                            id="validationCustom01" value="{{ $data->freight_order_id }}" required>
                                    </div>


                                    @if ($data->NFenviada)
                                        <div class="alert alert-success" role="alert">
                                            Nota Fiscal Já Cadastrada no sistema.
                                        </div>
                                    @else
                                        <div class="mb-3 mt-2">
                                            <input type="file" class="form-control" name="file"
                                                aria-label="file example" required>
                                            <div class="invalid-feedback">Example invalid form file feedback</div>
                                        </div>

                                        <div class="mb-3">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="bi bi-send-plus"></i>
                                                Enviar</button>
                                        </div>
                                    @endif
                                </form>
                            </div>
                            <!-- End -->
                        </div>
                        <!-- End -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
