package model.entity;

import br.framework.annotations.TableAnnotation;
import br.framework.classes.DataBase.EntityClass;
import model.field.Codigo;
import model.field.Literal;
import model.field.Status;
import java.io.Serializable;

@TableAnnotation(tableName = "Categoria", prefix = "cat_")
public class Categoria extends EntityClass implements Serializable {
    private Codigo id;
    private Literal descricao;
    private Status status;

    public Categoria (){
        super();
        this.status.setValue("N");

    }

    public Codigo getId() {
        return id;
    }

    public void setId(Codigo id) {
        this.id = id;
    }

    public Literal getDescricao() {
        return descricao;
    }

    public void setDescricao(Literal descricao) {
        this.descricao = descricao;
    }

    public Status getStatus() {
        return status;
    }

    public void setStatus(Status status) {
        this.status = status;
    }
}
