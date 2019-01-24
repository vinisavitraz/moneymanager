package model.entity;

import br.framework.annotations.TableAnnotation;
import br.framework.classes.DataBase.EntityClass;
import model.field.*;

import java.io.Serializable;

@TableAnnotation(tableName = "Cartao", prefix = "cart_")
public class Cartao extends EntityClass implements Serializable {
    private Codigo id;
    private Literal numero;
    private Literal descricao;
    private Status tipo; //verificar como criar enum de string
    private Data dataVencimento;
    private Decimal saldo;
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

    public Literal getNumero() {
        return numero;
    }

    public void setNumero(Literal numero) {
        this.numero = numero;
    }

    public Literal getDescricao() {
        return descricao;
    }

    public void setDescricao(Literal descricao) {
        this.descricao = descricao;
    }

    public Status getTipo() {
        return tipo;
    }

    public void setTipo(Status tipo) {
        this.tipo = tipo;
    }

    public Data getDataVencimento() {
        return dataVencimento;
    }

    public void setDataVencimento(Data dataVencimento) {
        this.dataVencimento = dataVencimento;
    }

    public Decimal getSaldo() {
        return saldo;
    }

    public void setSaldo(Decimal saldo) {
        this.saldo = saldo;
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
