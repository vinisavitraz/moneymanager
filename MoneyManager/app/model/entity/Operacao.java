package model.entity;

import br.framework.annotations.TableAnnotation;
import br.framework.classes.DataBase.EntityClass;
import model.field.*;

import java.io.Serializable;

@TableAnnotation(tableName = "Operacao", prefix = "op_")
public class Operacao extends EntityClass implements Serializable {
    private Codigo id;
    private Status tipo;
    private Literal descricao;
    private Codigo idUsuario;
    private Status status;
    private Status ativo;

    //add contrutor status ativo

    public Codigo getId() {
        return id;
    }

    public void setId(Codigo id) {
        this.id = id;
    }

    public Status getTipo() {
        return tipo;
    }

    public void setTipo(Status tipo) {
        this.tipo = tipo;
    }

    public Literal getDescricao() {
        return descricao;
    }

    public void setDescricao(Literal descricao) {
        this.descricao = descricao;
    }

    public Codigo getIdUsuario() {
        return idUsuario;
    }

    public void setIdUsuario(Codigo idUsuario) {
        this.idUsuario = idUsuario;
    }

    public Status getStatus() {
        return status;
    }

    public void setStatus(Status status) {
        this.status = status;
    }

    public Status getAtivo() {
        return ativo;
    }

    public void setAtivo(Status ativo) {
        this.ativo = ativo;
    }
}
