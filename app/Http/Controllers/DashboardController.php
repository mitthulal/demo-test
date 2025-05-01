<?PHP 

namespace App\Http\Controllers;

use App\Models\Client;

class DashboardController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('dashboard', compact('clients'));
    }
}
