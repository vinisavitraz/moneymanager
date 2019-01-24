package controllers.web;

import play.mvc.Result;

import static play.mvc.Results.ok;

public class CategoriaWeb {
    public Result index() {
        return ok(views.html.categoria.categorias.render());
    }

}
