<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                Add Data
            </a>
            <a href="{{ route('categories.excelExport') }}" class="btn btn-success">
                <i class="fa-regular fa-file-excel"></i>
                Excel
            </a>
            <a href="{{ route('categories.pdfExport') }}" class="btn btn-danger">
                <i class="fa-regular fa-file-pdf"></i>
                PDF
            </a>
        </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <th>No.</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($categories as $index => $category)
                    <tr>
                        <td style="width: 50px; text-align:center">{{ $index + 1 }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->slug }}</td>
                        <td style="width: 100px; text-align:center">
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline delete-data">
                                <div class="btn-group">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">
                                        <i class="fa fa-pencil-alt"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" title='Delete'>
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- /.card-body -->
</div>
