package controllers.web;

import play.mvc.Result;

import static play.mvc.Results.ok;

public class InicialWeb {
    public Result index() {
        return ok(views.html.inicial.render());
    }
}
