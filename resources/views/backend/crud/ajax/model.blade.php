namespace App;

use Illuminate\Database\Eloquent\Model;
 
class {{ $class }} extends Model
{
    protected $table = '{{ $table }}';
 
    protected $guarded = [];
}
