                                    <form method="POST" class="form" action="{{ route($lien.'.update',$permission->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-5 col-12">
                                                <div class="mb-1">
                                                    <label>Sous menu </label>
                                                    <select name="id_sousmenu" id="id_sousmenu" required  class="select2  form-select">
                                                        <?= $SousMenuList; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="mb-1">
                                                    <label>Libellé </label>
                                                    <input type="text" name="lib_permission" id="lib_permission"
                                                           class="form-control form-control-sm"
                                                           placeholder="Libellé" value="{{$permission->lib_permission}}">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Code </label>
                                                    <input type="text" name="name" id="name"
                                                           class="form-control form-control-sm" placeholder="Priorité" value="{{$permission->name}}"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Statut </label><br>
                                                    <input type="checkbox" class="form-check-input" name="is_valide" {{  ($permission->is_valide == true ? ' checked' : '') }}
                                                           id="colorCheck1">
                                                </div>
                                            </div>
                                            <div class="col-12" align="right">
                                                <hr>
                                                <button type="submit"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                    Enregistrer
                                                </button>
                                                <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                   href="/{{$lien }}">
                                                    Retour</a>
                                            </div>
                                        </div>
                                    </form>








