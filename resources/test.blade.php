<form action="{{ url('testpost') }}" method="POST">
                              {{ csrf_field() }}
                              <input name="user2"  type="text">
                               <button type="submit" class="btn btn-danger">
                                <i class="fa fa-child"></i> testnew
                              </button>
                          </form>