@extends('layouts.main')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="container-fluid" width="100%" height="100%">
        <iframe
            src="https://app.powerbi.com/view?r=eyJrIjoiMDY1YjcxNTgtZGZjNi00YWNjLTgxZjUtNGYwMmFlNzU2MGJlIiwidCI6ImRkZDM1YTcyLWE4OTAtNDJjMC05YWMwLWJiODRmZjkxNWE5ZSJ9&pageName=ReportSectionb3f3f11364b61038b6db"
            width="100%" height="550">
        </iframe>
    </div>
@endsection
