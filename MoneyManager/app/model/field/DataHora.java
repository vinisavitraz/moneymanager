package model.field;

import br.framework.classes.DataBase.EntityField;
import br.framework.classes.helpers.Types.FieldType;

import java.io.Serializable;
import java.util.Date;


public class DataHora extends EntityField implements Serializable {

	/**
   *
   */
  private static final long serialVersionUID = 3277102956712145190L;

  private Date value;

	public DataHora() {
		super();
		this.value = new Date();		
		this.setDataType(FieldType.DateTime);
		this.setPrecision(10);
		this.setScale(0);
	}

	@Override
	public Date getValue() {
		return this.value;
	}

	public void setValue(Date value) {
		Object ObjValue = value;
        this.setValue(ObjValue);
	}
	
	@Override
	public void setValue(Object value) {
        if (value != null) {
            if (java.sql.Date.class == value.getClass()) {
                java.sql.Date sqlDate = (java.sql.Date) value;
                if (sqlDate != null) {
                    value = new Date(sqlDate.getTime());
                }
            }
        }
        this.setHasModification(Boolean.TRUE);
        this.value = (Date) value;
    }

}
