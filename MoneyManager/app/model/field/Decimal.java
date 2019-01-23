package model.field;

import br.framework.classes.DataBase.EntityField;
import br.framework.classes.helpers.Types.FieldType;

import java.io.Serializable;


public class Decimal extends EntityField implements Serializable {

	/**
   * 
   */
  private static final long serialVersionUID = -720035125290742976L;
  
  private Double value;

	public Decimal() {
		super();
		this.value = 0.00;		
		this.setDataType(FieldType.BigDecimal);
		this.setPrecision(10);
		this.setScale(5);
	}

	@Override
	public Double getValue() {
		return this.value;
	}

	@Override
	public void setValue(Object value) {	
		this.setHasModification(Boolean.TRUE);
		if (value==null) {
			value = 0.00;
		}
		this.value = (Double) value;
	}
	
	public void setValue(Double value) {
		Object ObjValue = value;
		this.setValue(ObjValue);
	}

}
