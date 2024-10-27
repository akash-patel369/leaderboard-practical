<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leaderboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="bg-dark">
    <div class="container mt-3">
      <h1>Leaderboard</h1>

      <form action="{{ route('leaderboard.index') }}" method="GET">
        <div class="row mb-3">
          <div class="col-4">
            <label class="text-white">User Id</label>
            <input class="form-control form-control-sm" type="text" name="user_id" placeholder="Search by User ID">
          </div>
          {{-- <input type="date" name="day" placeholder="Filter by Day">
          <input type="month" name="month" placeholder="Filter by Month">
          <input type="number" name="year" placeholder="Filter by Year"> --}}
          <div class="col-4">
            <label>&nbsp;</label></br>
            <button class="btn btn-sm btn-primary" type="submit">Filter</button>
          </div>
        </div>
      </form>

      <div class="mb-3">
        <label class="text-white">Sort By</label>
        <div class="d-flex flex-row gap-3">
          <form action="{{ route('leaderboard.index') }}" method="GET">
            <input type="hidden" name="day">
            <button class="btn btn-sm btn-primary" type="submit">Day</button>
          </form>
          <form action="{{ route('leaderboard.index') }}" method="GET">
            <input type="hidden" name="month">
            <button class="btn btn-sm btn-primary" type="submit">Month</button>
          </form>
          <form action="{{ route('leaderboard.index') }}" method="GET">
            <input type="hidden" name="year">
            <button class="btn btn-sm btn-primary" type="submit">Year</button>
          </form> 
        </div>
      </div>

      <form action="{{ route('leaderboard.recalculate') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-sm btn-primary">Re-calculate</button>
      </form>

      <div class="table-responsive mt-3">
        <table class="table table-dark table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Total Points</th>
              <th>Rank</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->full_name }}</td>
              <td>{{ $user->total_points }}</td>
              <td>#{{ $user->rank }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>