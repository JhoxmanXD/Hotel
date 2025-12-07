@extends ('layouts.app')

@section ('content')
<div class="content-wrapper">
    <section class="content-header">
		<div class="container-fluid">
		</div>
    </section>
	@include('layouts.partials.msg')
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-10">
					<div class="card">
						<div class="card-header bg-secondary">
							<h3>@yield('title')</h3>
						</div>
						<form method="POST" action="{{ route('employees.store') }}">
							@csrf
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
										<div class="form-group label-floating">
											<label class="control-label">Nombre <strong style="color:red;">(*)</strong></label>
											<input type="text" class="form-control" name="name" autocomplete="off" value="{{ old('name') }}" required>
										</div>
									</div>
								</div>
								<div class="row">
									
								</div>
								<div class="row">
									<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
										<div class="form-group label-floating">
											<label class="control-label">Documento <strong style="color:red;">(*)</strong></label>
											<input type="text" class="form-control" name="documentNumber" autocomplete="off" value="{{ old('documentNumber') }}" required>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
										<div class="form-group label-floating">
											<label class="control-label">Direccion <strong style="color:red;">(*)</strong></label>
											<input type="text" class="form-control" name="address" autocomplete="off" value="{{ old('address') }}">
										</div>
									</div>
									<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
										<div class="form-group label-floating">
											<label class="control-label">Telefono <strong style="color:red;">(*)</strong></label>
											<input type="text" class="form-control" name="phone" autocomplete="off" value="{{ old('phone') }}">
										</div>
									</div>
									<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
										<div class="form-group label-floating">
											<label class="control-label">Email <strong style="color:red;">(*)</strong></label>
											<input type="text" class="form-control" name="email" autocomplete="off" value="{{ old('email') }}">
										</div>
									</div>
								</div>
								<!-- <input type="hidden" class="form-control" name="estado" value="1">
								<input type="hidden" class="form-control" name="registradoPor" value="{{ Auth::user()->id }}"> -->
							</div>
							<input type="hidden" class="form-control" name="estado" value="1">
								<input type="hidden" class="form-control" name="registradoPor" value="{{ Auth::user()->id }}">
							<div class="card-footer">
								<div class="row">
									<div class="col-lg-2 col-xs-4">
										<button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
									</div>
									<div class="col-lg-2 col-xs-4">
										<a href="{{ route('employees.index') }}" class="btn border  btn-block btn-flat">Cancelar</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

@endsection
