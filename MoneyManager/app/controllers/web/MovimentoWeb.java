package controllers.web;

import play.mvc.Result;

import static play.mvc.Results.ok;

public class MovimentoWeb {
    public Result index() {
        return ok(views.html.movimento.movimentos.render());
    }
}
