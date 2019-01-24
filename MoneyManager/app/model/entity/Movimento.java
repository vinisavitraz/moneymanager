package model.entity;

import br.framework.annotations.TableAnnotation;
import br.framework.classes.DataBase.EntityClass;
import model.field.*;

import java.io.Serializable;


@TableAnnotation(tableName = "Movimento", prefix = "mov_")
public class Movimento extends EntityClass implements Serializable {
    private Codigo id;
    private Literal transacao;
    private Status tipo;
    private Literal descricao;
    private Decimal valor;
    private Data dataMov;
    private Codigo idOperacao;
    private Codigo idCategoria;
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

    public Literal getTransacao() {
        return transacao;
    }

    public void setTransacao(Literal transacao) {
        this.transacao = transacao;
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

    public Decimal getValor() {
        return valor;
    }

    public void setValor(Decimal valor) {
        this.valor = valor;
    }

    public Data getDataMov() {
        return dataMov;
    }

    public void setDataMov(Data dataMov) {
        this.dataMov = dataMov;
    }

    public Codigo getIdOperacao() {
        return idOperacao;
    }

    public void setIdOperacao(Codigo idOperacao) {
        this.idOperacao = idOperacao;
    }

    public Codigo getIdCategoria() {
        return idCategoria;
    }

    public void setIdCategoria(Codigo idCategoria) {
        this.idCategoria = idCategoria;
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
