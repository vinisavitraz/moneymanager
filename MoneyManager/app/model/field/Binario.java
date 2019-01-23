package model.field;

import br.framework.classes.DataBase.EntityField;
import br.framework.classes.helpers.Types.FieldType;

import java.io.Serializable;


public class Binario extends EntityField implements Serializable {

	/**
   * 
   */
  private static final long serialVersionUID = -2156178518936620393L;
  
  private Byte[] value;

	public Binario() {
		super();
		this.value = new Byte[0];		
		this.setDataType(FieldType.Blob);
		this.setPrecision(20);
		this.setScale(0);
	}

	@Override
	public Byte[] getValue() {		
		return this.value;
	}
 
	public void setValue(Byte[] value) {
		Object ObjValue = value; 
		if (value==null) {
			value = new Byte[0];
		}
		this.setValue(ObjValue);
	}
	
	@Override
	public void setValue(Object value) {
		this.setHasModification(Boolean.TRUE);
		this.value = (Byte[]) value;
	}

}
